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

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productTabsRepository;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context                            $context
     * @param \Magento\Ui\Component\MassAction\Filter                        $filter
     * @param \Magento\Catalog\Api\ProductRepositoryInterface                $productTabsRepository
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Catalog\Api\ProductRepositoryInterface $productTabsRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->productTabsRepository = $productTabsRepository;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Executing mass delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        /*** @var \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $collection */
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        if ($collectionSize > 0) {
            /*** @var \Magento\Catalog\Api\Data\ProductInterface $item */
            foreach ($collection as $item) {
                $this->productTabsRepository->delete($item);
            }
        }
        $this->messageManager->addSuccessMessage(
            __(
                'A total of %1 record(s) have been deleted.',
                $collectionSize
            )
        );

        /*** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory
            ->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
