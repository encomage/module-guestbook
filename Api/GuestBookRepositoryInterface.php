<?php

namespace Encomage\GuestBook\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface GuestBookRepositoryInterface
 *
 * @package Encomage\GuestBook\Api
 */
interface GuestBookRepositoryInterface
{
    /**
     * @param Data\GuestBookInterface $request
     * @return mixed
     */
    public function save(Data\GuestBookInterface $request);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param $messageId
     * @return mixed
     */
    public function getByMessageId($messageId);

    /**
     * @param Data\GuestBookInterface $request
     * @return mixed
     */
    public function delete(Data\GuestBookInterface $request);

    /**
     * @param $messageId
     * @return mixed
     */
    public function deleteByMessageId($messageId);

    /**
     * @param array $messageIds
     * @return mixed
     */
    public function massDeleteByMessageIds(array $messageIds);

}