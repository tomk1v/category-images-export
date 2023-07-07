<?php
/**
 * Product Menu
 *
 * @category  Mtwoe
 * @package   Mtwoe\ProductMenu
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Mtwoe\ProductMenu\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
    /**
     * User email configuration path
     */
    const PRODUCT_MENU_USER_EMAIL = 'mtwoe/product_menu/email';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @param \Magento\Backend\App\Action\Context                $context
     * @param \Magento\Framework\View\Result\PageFactory         $resultPageFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Product Menu admin page
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mtwoe_ProductMenu::home');
        $resultPage->getConfig()->getTitle()->prepend((__('User Installation Info')));

        $userEmail = $this->scopeConfig->getValue(self::PRODUCT_MENU_USER_EMAIL, 'default', 0);
        if ($userEmail) {
            $resultRedirect = $this->redirectFactory->create();
            $resultRedirect->setPath('*/products/index');
            return $resultRedirect;
        } else {
            return $resultPage;
        }
    }
}
