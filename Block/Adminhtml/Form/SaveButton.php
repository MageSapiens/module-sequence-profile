<?php

namespace Sapiens\SequenceProfile\Block\Adminhtml\Form;

use Magento\Cms\Block\Adminhtml\Block\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Save entity button.
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Save button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label'          => __('Save'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'cms_block_form.cms_block_form',
                                'actionName' => 'save',
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
