<?php

namespace Encomage\GuestBook\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

/**
 * Class Answer
 *
 * @package Encomage\GuestBook\Controller\Ajax
 */
class Answer extends Action
{
    /**
     * @var JsonFactory
     */
    protected $_jsonFactory;

    /**
     * @var RedirectFactory
     */
    protected $_redirectFactory;

    /**
     * Answer constructor.
     *
     * @param Context $context
     * @param JsonFactory $jsonResultFactory
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonResultFactory,
        RedirectFactory $redirectFactory
    ) {
        $this->_jsonFactory = $jsonResultFactory;
        $this->_redirectFactory = $redirectFactory;
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->messageManager->addErrorMessage(__('Incorrect Params.'));
            $resultRedirect = $this->_redirectFactory->create();

            return $resultRedirect->setRefererUrl();
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response = ['success' => true];
        $messageId = (int)$this->getRequest()->getParam('messageId', 0);
        if (!$messageId) {
            $response['success'] = false;

            return $resultJson->setData($response);
        }

        $blockAnswer = $this->_view->getLayout()->createBlock('Encomage\GuestBook\Block\Comments\Answer');
        if (!$blockAnswer) {
            $response['success'] = false;

            return $resultJson->setData($response);
        } else {
            $blockAnswer->setMessageId($messageId);
            $response['html'] = $blockAnswer->getAnswerHtml();
        }

        return $resultJson->setData($response);
    }
}