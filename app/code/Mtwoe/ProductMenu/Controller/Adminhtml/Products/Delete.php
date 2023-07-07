<?php
/**
 * Product Menu
 *
 * @category  Mtwoe
 * @package   Mtwoe\ProductMenu
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Mtwoe\ProductMenu\Controller\Adminhtml\Products;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @param \Magento\Backend\App\Action\Context             $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface
    ) {
        parent::__construct($context);
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * Execution of delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        /*** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($entityId) {
            try {
                $product = $this->productRepositoryInterface->getById($entityId);
                $this->productRepositoryInterface->delete($product);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $entityId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a record to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
