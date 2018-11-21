<?php

namespace Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Encomage\GuestBook\Api\Data\GuestBookInterface;

/**
 * Class GuestBookStatusFilter
 *
 * @package Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor
 */
class OnlyQuestionsFilter implements CustomFilterInterface
{
    /**
     * @param Filter $filter
     * @param AbstractDb $collection
     * @return $this|bool
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        $collection->addFieldToFilter(GuestBookInterface::REPLY_PATH, ['null' => true]);

        return $this;
    }

}