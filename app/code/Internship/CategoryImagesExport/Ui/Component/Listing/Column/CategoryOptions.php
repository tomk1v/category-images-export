<?php
/**
 * Category Images Export
 *
 * @category Internship
 * @package Internship\CategoryImagesExport
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 tomk1v
 */

namespace Internship\CategoryImagesExport\Ui\Component\Listing\Column;

class CategoryOptions implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        protected \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $categoryCollection = $this->categoryCollectionFactory->create()->addAttributeToSelect('name');

        foreach ($categoryCollection as $category) {
            $options[] = [
                'label' => $category->getName(),
                'value' => $category->getId(),
            ];
        }

        return $options;
    }
}
