<?php

namespace Encomage\GuestBook\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\Escaper;

/**
 * Class RowActions
 *
 * @package Encomage\GuestBook\Ui\Component\Listing\Column
 */
class RowActions extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * RowActions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $id = $this->escaper->escapeHtml($item['message_id']);
                $item[$this->getData('name')] = [
                    'edit'   => [
                        'href'  => $this->urlBuilder->getUrl(
                            'guest_book/index/edit',
                            [
                                'message_id' => $item['message_id'],
                            ]
                        ),
                        'label' => __('Edit'),
                    ],
                    'delete' => [
                        'href'    => $this->urlBuilder->getUrl(
                            'guest_book/index/delete',
                            [
                                'message_id' => $item['message_id'],
                            ]
                        ),
                        'label'       => __('Delete'),
                        'confirm'     => [
                            'title'   => __('Delete %1', $id),
                            'message' => __('Are you sure you want to delete a %1 record?', $id),
                        ],
                    ],
                ];
            }
        }

        return $dataSource;
    }
}