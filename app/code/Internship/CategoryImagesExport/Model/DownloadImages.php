<?php
/**
 * Category Images Export
 *
 * @category Internship
 * @package Internship\CategoryImagesExport
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 tomk1v
 */

namespace Internship\CategoryImagesExport\Model;

class DownloadImages
{
    /**
     * @param \Magento\Framework\Filesystem\DirectoryList $directoryList
     * @param \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Filesystem\Driver\File $file
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \ZipArchive $zipArchive
     */
    public function __construct(
        protected \Magento\Framework\Filesystem\DirectoryList $directoryList,
        protected \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
        protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        protected \Magento\Framework\Filesystem\Driver\File $file,
        protected \Magento\Framework\Message\ManagerInterface $messageManager,
        protected \ZipArchive $zipArchive
    ) {
    }

    /**
     * @param $categoryId
     * @return string
     * @throws \Exception
     */
    public function execute($categoryId)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('category_id', $categoryId)->create();
        $productCollection = $this->productRepositoryFactory->create()->getList($searchCriteria);

        $productItems = $productCollection->getItems();
        if ($productItems) {
            $exportDirectory = $this->directoryList->getPath('media') . '/category_images_export';

            if (!$this->file->isDirectory($exportDirectory)) {
                $this->file->createDirectory($exportDirectory);
            }

            $zipFileName = "category_$categoryId.zip";
            $zipFilePath = $exportDirectory . '/' . $zipFileName;

            $this->zipArchive->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            foreach ($productItems as $product) {
                $productImages = $product->getMediaGalleryImages();
                foreach ($productImages as $image) {
                    $imageUrl = $image->getUrl();
                    $imageContent = file_get_contents($imageUrl);
                    $this->zipArchive->addFromString(basename($imageUrl), $imageContent);
                }
            }

            $this->zipArchive->close();

            return $zipFileName;
        }

        return false;
    }
}
