<?php

namespace Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Encomage\GuestBook\Api\Data\GuestBookInterface;
use Encomage\GuestBook\Model\GuestBook\Source\Status;

/**
 * Class CustomSearchFilter
 *
 * @package Encomage\GuestBook\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor
 */
class CustomSearchFilter implements CustomFilterInterface
{
    /**
     * @param Filter $filter
     * @param AbstractDb $collection
     * @return $this|bool
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        if (is_array($filter->getValue())) {
            $condition = '(' . GuestBookInterface::REPLY_PATH . ' LIKE \'%' . $filter->getValue()[GuestBookInterface::MESSAGE_ID] . '%\'' . ')';
            $condition .= ' AND ((' . GuestBookInterface::STATUS . '=' . Status::STATUS_PENDING . ') AND (' . GuestBookInterface::SESSION_ID . '=\'' . $filter->getValue()[GuestBookInterface::SESSION_ID] . '\') OR (' . GuestBookInterface::STATUS . '=' . Status::STATUS_APPROVED . '))';
        } else {
            $condition = '(' . GuestBookInterface::REPLY_PATH . ' LIKE \'%' . $filter->getValue() . '%\'' . ') AND (' . GuestBookInterface::STATUS . '=' . Status::STATUS_APPROVED . ')';
        }
        $collection->getSelect()->where($condition);

        return $this;
    }

}