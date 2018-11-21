<?php

namespace Encomage\GuestBook\Api;

use Encomage\GuestBook\Model\GuestBook\Source\Status;

/**
 * Class SearchResults
 *
 * @package Encomage\GuestBook\Api
 */
class SearchResults extends \Magento\Framework\Api\SearchResults
    implements \Encomage\GuestBook\Api\Data\GuestBookSearchResultsInterface
{
    /**
     * @var null
     */
    protected $_arrayTree = null;

    /**
     * @var null
     */
    protected $_collection = null;

    /**
     * @return mixed
     */
    public function asTree()
    {
        if ($this->_arrayTree === null) {
            $this->_arrayTree = [];
            $items = $this->getItems();
            /** @var \Encomage\GuestBook\Model\GuestBook $item */
            foreach ($items as $item) {
                if (!$item->getReplyPath()) {
                    $this->_arrayTree[$item->getMessageId()] = $item;
                } else {
                    $pathPieces = explode('/', $item->getReplyPath());
                    $pathPieces[] = $item->getId();
                    $key = $pathPieces[0];
                    unset($pathPieces[0]);
                    $this->_putToArray($this->_arrayTree[$key], $pathPieces, $items);
                }
            }
        }

        return $this->_arrayTree;
    }

    /**
     * @return \Magento\Framework\Api\AbstractExtensibleObject[]|\Magento\Framework\Api\ExtensibleDataInterface[]|mixed|null
     */
    public function getItems()
    {
        if ($this->_get(self::KEY_ITEMS) === null) {
            $this->setItems($this->getCollection()->getItems());
        }

        return $this->_get(self::KEY_ITEMS);
    }

    /**
     * @return null|\Encomage\GuestBook\Model\ResourceModel\GuestBook\Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }

    /**
     * @param $collection
     * @return $this
     */
    public function setCollection($collection)
    {
        if (is_null($this->_collection)) {
            /**   @var $collection \Encomage\GuestBook\Model\ResourceModel\GuestBook\Collection */
            $this->_collection = $collection;
        }

        return $this;
    }

    /**
     * @param $object
     * @param $pieces
     * @param $items
     * @return $this
     */
    protected function _putToArray($object, $pieces, $items)
    {
        foreach ($pieces as $key => $id) {
            if ((int)$object->getStatus() === (int)Status::STATUS_REJECTED) {
                break;
            }
            $object->setAnswer($items[$id]);
            unset($pieces[$key]);
            $this->_putToArray($object->getAnswer()[$id], $pieces, $items);
            break;
        }

        return $this;
    }
}