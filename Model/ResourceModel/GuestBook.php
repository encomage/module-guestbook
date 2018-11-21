<?php

namespace Encomage\GuestBook\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class GuestBook
 *
 * @package Encomage\GuestBook\Model\ResourceModel
 */
class GuestBook extends AbstractDb
{
    /**
     * Class construct.
     */
    protected function _construct()
    {
        $this->_init('guest_book', 'message_id');
    }
}