<?php

namespace Encomage\GuestBook\Controller\Adminhtml\Index;

use Encomage\GuestBook\Model\GuestBookFactory;
use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class Save
 *
 * @package Encomage\GuestBook\Controller\Adminhtml\Index
 */
class Save extends Action
{
    /**
     * @var GuestBookRepositoryInterface
     */
    private $guestBookRepository;

    /**
     * @var GuestBookFactory
     */
    private $guestBookFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param GuestBookFactory $guestBookFactory
     * @param GuestBookRepositoryInterface $guestBookRepository
     * @param DataPersistorInterface $dataPersistor
     * @param DateTime $dateTime
     */

    public function __construct(
        Action\Context $context,
        GuestBookFactory $guestBookFactory,
        GuestBookRepositoryInterface $guestBookRepository,
        DataPersistorInterface $dataPersistor,
        DateTime $dateTime


    ) {
        $this->dataPersistor = $dataPersistor;
        $this->guestBookRepository = $guestBookRepository;
        $this->guestBookFactory = $guestBookFactory;
        $this->dateTime = $dateTime;
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getPostValue();
        if (!empty($params)) {
            $message_id = (int)$this->getRequest()->getParam('message_id', 0);
            if ($message_id) {
                $model = $this->guestBookRepository->getByMessageId($message_id);
            } else {
                $model = $this->guestBookFactory->create();
                unset($params['message_id']);
            }
            $params['updated_at'] = $this->dateTime->gmtDate();
            if (isset($params['session_id'])) {
                $params['session_id'] = null;
            }
            $model->setData($params);
            try {
                $this->guestBookRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Saved successfully.'));
                $this->dataPersistor->clear('guest_book_message');
                $param = $this->getRequest()->getParam('back');
                if (!$param) {
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (LocalizedException $localizedException) {
                $this->messageManager->addErrorMessage($localizedException->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something wrong'));
            }
            $this->dataPersistor->set('guest_book_message', $params);
            $redirectParams = ($message_id) ? ['message_id' => $message_id] : [];

            return $resultRedirect->setPath('*/*/edit', $redirectParams);
        }

        return $resultRedirect->setPath('*/*/index');
    }
}