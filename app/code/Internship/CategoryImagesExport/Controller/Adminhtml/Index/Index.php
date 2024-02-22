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

class Index extends \Magento\Backend\App\Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        protected \Magento\Backend\App\Action\Context $context,
        protected \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Product Menu admin page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Internship_CategoryImagesExport::home');
        $resultPage->getConfig()->getTitle()->prepend((__('Category Images Export')));

        return $resultPage;
    }
}
