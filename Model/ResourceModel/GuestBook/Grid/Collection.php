<?php

namespace Encomage\GuestBook\Model\ResourceModel\GuestBook\Grid;

use Encomage\GuestBook\Model\ResourceModel\GuestBook\Collection as GuestBookCollection;
use Magento\Framework\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Encomage\GuestBook\Model\ResourceModel\GuestBook;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class Collection
 *
 * @package Encomage\GuestBook\Model\ResourceModel\GuestBook\Grid
 */
class Collection extends GuestBookCollection implements SearchResultInterface
{
    /**
     * @var $aggregations
     */
    protected $_aggregations;
    
    /**
     * Class construct.
     */
    protected function _construct()
    {
        $this->_init(Document::class, GuestBook::class);
    }
    
    /**
     * @return \Magento\Framework\Api\Search\AggregationInterface
     */
    public function getAggregations()
    {
        return $this->_aggregations;
    }

    /**
     * @param \Magento\Framework\Api\Search\AggregationInterface $aggregations
     * @return $this|void
     */
    public function setAggregations($aggregations)
    {
        $this->_aggregations = $aggregations;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * @return \Magento\Framework\Api\Search\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}