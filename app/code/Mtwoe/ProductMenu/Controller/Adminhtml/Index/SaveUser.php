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

class SaveUser extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $resourceConfig;

    /**
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @param \Magento\Backend\App\Action\Context                $context
     * @param \Magento\Config\Model\ResourceModel\Config         $resourceConfig
     * @param \Magento\Framework\Message\ManagerInterface        $messageManager
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Config\Model\ResourceModel\Config $resourceConfig,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory,
    ) {
        parent::__construct($context);
        $this->resourceConfig = $resourceConfig;
        $this->messageManager = $messageManager;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\Message\ManagerInterface
     */
    public function execute()
    {
        if ($this->getRequest()->getParam('form_key')) {
            $data = $this->getRequest()->getPostValue();

            array_pop($data);
            foreach ($data as $key => $value) {
                $this->resourceConfig->saveConfig(
                    'mtwoe/product_menu/'. $key . '',
                    $value
                );
            }

            $this->messageManager->addSuccessMessage('User info saved successfully');
            $resultRedirect = $this->redirectFactory->create();
            $resultRedirect->setPath('*/products/index');
            return $resultRedirect;
        } else {
            return $this->messageManager->addErrorMessage('Form key is not valid');
        }
    }
}
