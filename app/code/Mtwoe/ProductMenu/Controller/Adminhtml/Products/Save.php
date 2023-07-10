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

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @param \Magento\Backend\App\Action\Context                  $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface      $productRepository
     * @param \Magento\Framework\App\Request\Http                  $request
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->productRepository = $productRepository;
        $this->request = $request;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $productData = $this->request->getPostValue();
        if (!empty($productData)) {
            $product = $this->productRepository->getById($productData['entity_id'], false, 0);
            $product->setName($productData['name'])->setPrice($productData['price']);
            $product->getExtensionAttributes()->getStockItem()
                ->setQty($productData['qty'])->setIsInStock((bool)$productData['qty']);

            try {
                $this->productRepository->save($product);
                $this->messageManager->addSuccessMessage(__('Product saved successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error occurred while saving product: %1', $e->getMessage()));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');
        return $resultRedirect;
    }
}
