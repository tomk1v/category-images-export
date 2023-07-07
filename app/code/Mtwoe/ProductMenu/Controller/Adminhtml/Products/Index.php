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

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Product Menu admin page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mtwoe_ProductMenu::products');
        $resultPage->getConfig()->getTitle()->prepend((__('Product Menu')));

        return $resultPage;
    }
}
