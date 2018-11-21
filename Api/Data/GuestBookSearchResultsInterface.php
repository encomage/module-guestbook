<?php

namespace Encomage\GuestBook\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface GuestBookSearchResultsInterface
 *
 * @package Encomage\GuestBook\Api\Data
 */
interface GuestBookSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return $this
     */
    public function setItems(array $items);

    /**
     * @return mixed
     */
    public function asTree();
}