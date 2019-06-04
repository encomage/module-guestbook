<?php

namespace Encomage\GuestBook\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Encomage\GuestBook\Block\Comments\Questions;

/**
 * Class Listing
 *
 * @package Encomage\GuestBook\Controller\Ajax
 */
class Listing extends Action
{
    /** @var RedirectFactory */
    private $_redirectFactory;

    /**
     * Listing constructor.
     *
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(Context $context, RedirectFactory $redirectFactory)
    {
        parent::__construct($context);
        $this->_redirectFactory = $redirectFactory;
    }

    /**
     * @return $this
     *          |\Magento\Framework\App\ResponseInterface
     *          |\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->messageManager->addErrorMessage(__('Incorrect Params.'));

            /** @var \Magento\Framework\Controller\ResultInterface $resultRedirect */
            $resultRedirect = $this->_redirectFactory->create();

            return $resultRedirect->setRefererUrl();
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $blockContent = $this->_view->getLayout()->createBlock(Questions::class);

        $result = [];
        $html = $blockContent->toHtml();

        if ($html && $blockContent->getPagerBlock()) {
            $result['currentPage'] = (int)$blockContent->getPagerBlock()->getCurrentPage();
        }
        $result['html'] = $html;
        $result['count'] = count($blockContent->getItems());

        return $resultJson->setData($result);
    }
}