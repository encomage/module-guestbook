<?php

namespace Encomage\GuestBook\Api\Data;

/**
 * Interface GuestBookInterface
 * @package Encomage\GuestBook\Api\Data
 */
interface GuestBookInterface
{
    const MESSAGE_ID      = 'message_id',
          STORE_ID        = 'store_id',
          CUSTOMER_ID     = 'customer_id',
          REPLY_PATH      = 'reply_path',
          STATUS          = 'status',
          MESSAGE         = 'message',
          NAME            = 'name',
          SUBJECT         = 'subject',
          EMAIL           = 'email',
          SESSION_ID      = 'session_id',
          CREATED_AT      = 'created_at',
          UPDATED_AT      = 'updated_at',
          CUSTOMER_REVIEW = 'customer_review';

    /**
     * @return mixed
     */
    public function getMessageId();

    /**
     * @param int $message_id
     * @return mixed
     */
    public function setMessageId(int $message_id);

    /**
     * @return mixed
     */
    public function getStoreId();

    /**
     * @param int $store_id
     * @return mixed
     */
    public function setStoreId(int $store_id);

    /**
     * @return mixed
     */
    public function getCustomerId();

    /**
     * @param int $customer_id
     * @return mixed
     */
    public function setCustomerId(int $customer_id);

    /**
     * @return mixed
     */
    public function getReplyPath();

    /**
     * @param string $replyTo
     * @return mixed
     */
    public function setReplyPath(string $replyTo);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param int $status
     * @return mixed
     */
    public function setStatus(int $status);

    /**
     * @return mixed
     */
    public function getMessage();

    /**
     * @param string $message
     * @return mixed
     */
    public function setMessage(string $message);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @return mixed
     */
    public function getSubject();

    /**
     * @param string $subject
     * @return mixed
     */
    public function setSubject(string $subject);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param string $email
     * @return mixed
     */
    public function setEmail(string $email);

    /**
     * @return mixed
     */
    public function getSessionId();

    /**
     * @param int $session_id
     * @return mixed
     */
    public function setSessionId(int $session_id);

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @param string $date
     * @return mixed
     */
    public function setCreatedAt(string $date);

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param string $date
     * @return mixed
     */
    public function setUpdatedAt(string $date);

    /**
     * @return mixed
     */
    public function getCustomerReview();

    /**
     * @param int $customerReview
     * @return mixed
     */
    public function setCustomerReview(int $customerReview);
}