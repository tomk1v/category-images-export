<?php
/**
 * Product Menu
 *
 * @category  Mtwoe
 * @package   Mtwoe\ProductMenu
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Mtwoe\ProductMenu\Ui\DataProvider\ProductMenu;

class ProductDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $collection;

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param string                                                         $name
     * @param string                                                         $primaryFieldName
     * @param string                                                         $requestFieldName
     * @param array                                                          $meta
     * @param array                                                          $data
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $productCollectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $productsCollection = $this->collection->load();
        $items = $productsCollection->getData();
        return [
            'totalRecords' => $productsCollection->getSize(),
            'items' => $items,
        ];
    }
}
