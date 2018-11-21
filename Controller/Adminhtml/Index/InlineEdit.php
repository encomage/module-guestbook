<?php

namespace Encomage\GuestBook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class InlineEdit
 *
 * @package Encomage\GuestBook\Controller\Adminhtml\Index
 */
class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var GuestBookRepositoryInterface
     */
    private $guestBookRepository;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * InlineEdit constructor.
     *
     * @param Action\Context $context
     * @param JsonFactory $jsonFactory
     * @param GuestBookRepositoryInterface $guestBookRepository
     * @param DateTime $dateTime
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        GuestBookRepositoryInterface $guestBookRepository,
        DateTime $dateTime
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->guestBookRepository = $guestBookRepository;
        $this->dateTime = $dateTime;
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $params = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($params))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error'    => true,
            ]);
        }
        foreach ($params as $item) {
            $model = $this->guestBookRepository->getByMessageId($item['message_id']);
            $item['updated_at'] = $this->dateTime->gmtDate();
            $model->setData($item);
            $this->guestBookRepository->save($model);
        }

        return $resultJson->setData([
            'messages' => [__('Saved')],
            'error'    => false,
        ]);
    }
}