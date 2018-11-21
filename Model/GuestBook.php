<?php

namespace Encomage\GuestBook\Model;

use Encomage\GuestBook\Api\Data\GuestBookInterface;
use Encomage\GuestBook\Model\ResourceModel\GuestBook as GuestBookResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class GuestBook
 *
 * @package Encomage\GuestBook\Model
 */
class GuestBook extends AbstractModel implements GuestBookInterface
{
    /**
     * class construct
     */
    protected function _construct()
    {
        $this->_init(GuestBookResource::class);
    }
    
    /**
     * @return int|mixed
     */
    public function getMessageId()
    {
        return (int)$this->getData(self::MESSAGE_ID);
    }

    /**
     * @param int $messageId
     * @return $this|mixed
     */
    public function setMessageId(int $messageId)
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function setStoreId(int $storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param int $customerId
     * @return mixed
     */
    public function setCustomerId(int $customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @return mixed
     */
    public function getReplyPath()
    {
        return $this->getData(self::REPLY_PATH);
    }

    /**
     * @param string $replyTo
     * @return mixed
     */
    public function setReplyPath(string $replyTo)
    {
        return $this->setData(self::REPLY_PATH, $replyTo);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param int $status
     * @return mixed
     */
    public function setStatus(int $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function setMessage(string $message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * @param string $subject
     * @return mixed
     */
    public function setSubject(string $subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function setEmail(string $email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->getData(self::SESSION_ID);
    }

    /**
     * @param int $sessionId
     * @return mixed
     */
    public function setSessionId(int $sessionId)
    {
        return $this->setData(self::SESSION_ID, $sessionId);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function setCreatedAt(string $date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function setUpdatedAt(string $date)
    {
        return $this->setData(self::UPDATED_AT, $date);
    }

    /**
     * @return mixed
     */
    public function getCustomerReview()
    {
        return $this->getData(self::CUSTOMER_REVIEW);
    }

    /**
     * @param int $customerReview
     * @return $this|mixed
     */
    public function setCustomerReview(int $customerReview)
    {
        return $this->setData(self::CUSTOMER_REVIEW, $customerReview);
    }

    /**
     * @param $object
     * @return $this
     */
    public function setAnswer($object)
    {
        if ($this->hasData('answer')) {
            $answer = $this->getData('answer');
            $answer[$object->getId()] = $object;
            $this->setData('answer', $answer);
        } else {
            $this->setData('answer', [$object->getId() => $object]);
        }

        return $this;
    }
}