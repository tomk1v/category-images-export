<?php
/**
 * Category Images Export
 *
 * @category  Internship
 * @package   Internship\CategoryImagesExport
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Internship\CategoryImagesExport\Block\Adminhtml\Index;

class ExportButton extends \Magento\CatalogRule\Block\Adminhtml\Edit\GenericButton implements
    \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Export'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 20,
        ];
    }
}
