<?php

namespace Encomage\GuestBook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 *
 * @package Encomage\GuestBook\Controller\Adminhtml\Index
 */
class Edit extends Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()
            ->getTitle()
            ->prepend((__('Edit Comment')));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Encomage_GuestBook::guest_book');
    }
}