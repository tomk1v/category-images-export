<?php
/**
 * Category Images Export
 *
 * @category  Internship
 * @package   Internship\CategoryImagesExport
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Internship\CategoryImagesExport\Model;

class DownloadImages
{
    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * @var \Internship\CategoryImagesExport\Helper\FolderHelper
     */
    protected $folderHelper;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterfaceFactory
     */
    protected $productRepositoryFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param \Magento\Framework\Filesystem\DirectoryList $directoryList
     * @param \Internship\CategoryImagesExport\Helper\FolderHelper $folderHelper
     * @param \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Internship\CategoryImagesExport\Helper\FolderHelper $folderHelper,
        \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->directoryList = $directoryList;
        $this->folderHelper = $folderHelper;
        $this->productRepositoryFactory = $productRepositoryFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param $folderName
     * @param $categoryId
     * @return bool
     * @throws \Exception
     */
    public function execute($folderName, $categoryId)
    {
        try {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('category_id', $categoryId)->create();
            $productCollection = $this->productRepositoryFactory->create()->getList($searchCriteria);

            $productItems = $productCollection->getItems();
            if ($productItems) {
                $dir = $this->directoryList->getPath('media') . "/$folderName/";
                $this->folderHelper->ifFolderExist($dir);

                foreach ($productItems as $product) {
                    $productImages = $product->getMediaGalleryImages();
                    foreach ($productImages as $image) {
                        $imageUrl = $image->getUrl();
                        $filename = $dir . basename($imageUrl);

                        $this->folderHelper->saveImage($filename, $image);
                    }
                }
                return true;
            } else {
                return false;
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
