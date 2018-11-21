<?php

namespace Encomage\GuestBook\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 *
 * @package Encomage\GuestBook\Controller\Index
 */
class Index extends Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $result;
    }
}