<?php
/**
 * Category Images Export
 *
 * @category  Internship
 * @package   Internship\CategoryImagesExport
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Internship\CategoryImagesExport\Controller\Adminhtml\Index;

class Export extends \Magento\Backend\App\Action
{
    /**
     * @var \Internship\CategoryImagesExport\Model\DownloadImages
     */
    protected $downloadImages;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Internship\CategoryImagesExport\Model\DownloadImages $downloadImages
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Internship\CategoryImagesExport\Model\DownloadImages $downloadImages
    ) {
        parent::__construct($context);
        $this->downloadImages = $downloadImages;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|(\Magento\Framework\Controller\Result\Redirect&\Magento\Framework\Controller\ResultInterface)|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $formParams = $this->getRequest()->getParams();

        if ($formParams && isset($formParams['folder_name']) && $formParams['category_id']) {
            try {
                $ifImagesExported = $this->downloadImages
                    ->execute($formParams['folder_name'], $formParams['category_id']);

                if ($ifImagesExported) {
                    $this->messageManager->addSuccessMessage('Export was successfully.');
                } else {
                    $this->messageManager->addErrorMessage('No found products in category for exporting');
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage('Error exporting photos: ' . $e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage('Please submit form for category export correctly.');
        }
        return $resultRedirect->setPath('images_export/index/index');
    }
}
