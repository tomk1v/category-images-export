<?php
/**
 * Category Images Export
 *
 * @category Internship
 * @package Internship\CategoryImagesExport
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 tomk1v
 */

namespace Internship\CategoryImagesExport\Controller\Adminhtml\Index;

class Export extends \Magento\Backend\App\Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Internship\CategoryImagesExport\Model\DownloadImages $downloadImages
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        protected \Magento\Backend\App\Action\Context $context,
        protected \Internship\CategoryImagesExport\Model\DownloadImages $downloadImages,
        protected \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();

        try {
            $formParams = $this->getRequest()->getParams();

            if ($formParams && isset($formParams['category_id'])) {
                $zipFileName = $this->downloadImages->execute($formParams['category_id']);

                $this->messageManager->addSuccessMessage('Export was successfully.');
                return $resultJson->setData(['success' => true, 'message' => 'Export was successful.', 'zipFileName' => $zipFileName]);
            } else {
                $this->messageManager->addErrorMessage('Please submit form for category export correctly.');
                return $resultJson->setData(['success' => false]);
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage('Error exporting photos: ' . $exception->getMessage());
            return $resultJson->setData(['success' => false]);
        }
    }
}
