<?php

namespace Encomage\GuestBook\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class ResetButton
 *
 * @package Encomage\GuestBook\Block\Adminhtml\Edit
 */
class ResetButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'      => __('Reset'),
            'class'      => 'reset',
            'on_click'   => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}