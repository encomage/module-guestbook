<?php

namespace Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Encomage\GuestBook\Api\Data\GuestBookInterface;

/**
 * Class OnlyAnswerFilter
 *
 * @package Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor
 */
class OnlyAnswerFilter implements CustomFilterInterface
{
    /**
     * @param Filter $filter
     * @param AbstractDb $collection
     * @return $this|bool
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        if (!is_null($filter->getValue())) {
            $connection = $collection->getConnection();
            $condition =
                $connection->quoteInto('(' . GuestBookInterface::MESSAGE_ID . ' = ?)', $filter->getValue())
                . ' OR '
                . '(' . GuestBookInterface::REPLY_PATH . ' LIKE \'%' . $filter->getValue() . '%\')';
            $collection->getSelect()->where($condition);
        }

        return $this;
    }

}