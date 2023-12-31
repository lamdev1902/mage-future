<?php
declare(strict_types=1);

namespace MageDev\AssignProduct\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{

    /**
    * @return array
    */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                'button' => ['event' => 'saveAndContinueEdit'],
            ],
            ],
            'sort_order' => 80,
        ];
    }
}