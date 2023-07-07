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

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @param \Magento\Backend\App\Action\Context             $context
     * @param \Magento\Framework\View\Result\PageFactory      $resultPageFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface
     * @param \Magento\Framework\Message\ManagerInterface     $messageManager
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    /**
     * Execution of edit & save action
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        if ($entityId) {
            $product = $this->productRepositoryInterface->getById($entityId);
            if (!$product->getEntityId()) {
                $this->messageManager->addErrorMessage(__('This product no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mtwoe_ProductMenu::home');
        $resultPage->getConfig()->getTitle()->prepend(__('Product Menu Edit'));
        $resultPage->getConfig()->getTitle()->prepend($product->getName());

        return $resultPage;
    }
}
