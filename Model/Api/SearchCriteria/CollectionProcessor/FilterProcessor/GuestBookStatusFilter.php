<?php

namespace Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Encomage\GuestBook\Api\Data\GuestBookInterface;
use Encomage\GuestBook\Model\GuestBook\Source\Status;

/**
 * Class GuestBookStatusFilter
 *
 * @package Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor
 */
class GuestBookStatusFilter implements CustomFilterInterface
{
    /**
     * @param Filter $filter
     * @param AbstractDb $collection
     * @return $this|bool
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        $connection = $collection->getConnection();
        if (!is_null($filter->getValue())) {
            $condition = $connection->quoteInto('(' . GuestBookInterface::STATUS . ' = ?)', Status::STATUS_REJECTED)
                . ' OR ' .
                $connection->quoteInto('(' . GuestBookInterface::STATUS . ' = ?)', Status::STATUS_APPROVED)
                . ' OR ('
                . $connection->quoteInto('(' . GuestBookInterface::STATUS . ' = ?)', Status::STATUS_PENDING)
                . ' AND '
                . $connection->quoteInto('(' . GuestBookInterface::SESSION_ID . ' = ?)', $filter->getValue())
                . ')';
        } else {
            $condition = $connection->quoteInto('(' . GuestBookInterface::STATUS . ' = ?)', Status::STATUS_REJECTED)
                . ' OR ' .
                $connection->quoteInto('(' . GuestBookInterface::STATUS . ' = ?)', Status::STATUS_APPROVED);
        }

        $collection->getSelect()->where($condition);

        return $this;
    }

}