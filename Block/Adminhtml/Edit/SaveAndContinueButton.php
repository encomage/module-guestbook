<?php

namespace Encomage\GuestBook\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveAndContinueButton
 *
 * @package Encomage\GuestBook\Block\Adminhtml\Edit
 */
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __('Save and Continue Edit'),
            'class'          => 'save',
            'data_attribute' => [
                'mage-init'  => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order'     => 50,
        ];
    }
}