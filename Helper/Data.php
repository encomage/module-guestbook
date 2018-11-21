<?php

namespace Encomage\GuestBook\Helper;

use Encomage\GuestBook\Model\GuestBook;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Encomage\GuestBook\Helper\Config;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Area;

/**
 * Class Data
 *
 * @package Encomage\GuestBook\Helper
 */
class Data extends AbstractHelper
{
    const TEMPLATE_IDENTIFIER = "guest_book_add_new_comment";

    /**
     * @var \Encomage\GuestBook\Helper\Config
     */
    protected $config;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param \Encomage\GuestBook\Helper\Config $config
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     */
    public function __construct(
        Context $context,
        Config $config,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation
    ) {
        parent::__construct($context);
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
    }

    /**
     * @param GuestBook $comment
     * @return $this
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function notifyAboutPendingComment(GuestBook $comment)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $receiver = $this->config->getNotifyAdminRecipient();
        if (!$receiver) {
            return $this;
        }
        $this->inlineTranslation->suspend();
        $data = [];
        $data['message'] = $this->prepareMessage($comment->getMessage());
        $data['name'] = $comment->getName();
        $data['email'] = $comment->getEmail();
        $data['subject'] = $comment->getSubject();
        $data['store'] = $this->storeManager->getStore()->getName();
        $sender = $this->config->getNotifyAdminSender();
        $receivers = explode(",", $receiver);
        foreach ($receivers as $receiver) {
            /** @var \Magento\Framework\Mail\TransportInterface $transport */
            $transport = $this->transportBuilder->setTemplateIdentifier(self::TEMPLATE_IDENTIFIER)
                ->setTemplateOptions(
                    [
                        'area'  => Area::AREA_FRONTEND,
                        'store' => $storeId,
                    ]
                )
                ->setTemplateVars($data)
                ->setFrom($sender)
                ->addTo($receiver)
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();
        }

        return $this;
    }

    /**
     * @param $message
     * @return string
     */
    protected function prepareMessage($message)
    {
        $message = html_entity_decode($message);

        return strip_tags($message);
    }
}