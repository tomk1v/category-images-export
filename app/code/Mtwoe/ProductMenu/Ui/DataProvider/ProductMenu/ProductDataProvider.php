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
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\StockItemRepository
     */
    private $stockItemRepository;

    /**
     * @param string                                                         $name
     * @param string                                                         $primaryFieldName
     * @param string                                                         $requestFieldName
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param \Magento\CatalogInventory\Model\Stock\StockItemRepository      $stockItemRepository
     * @param array                                                          $meta
     * @param array                                                          $data
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->stockItemRepository = $stockItemRepository;
        $this->collection = $collectionFactory->create()->setStoreId(0);
    }

    /**
     * Default data for edit page
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->addAttributeToSelect('*')->getItems();
        /*** @var \Magento\Catalog\Api\Data\ProductInterface $location */
        foreach ($items as $item) {
            $itemId = $item->getId();
            $this->loadedData[$itemId] = $item->getData();
            $this->loadedData[$itemId]['qty'] = $this->stockItemRepository->get($itemId)->getQty();
        }

        return $this->loadedData;
    }
}
