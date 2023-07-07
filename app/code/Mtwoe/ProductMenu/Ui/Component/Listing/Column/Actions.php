<?php
/**
 * Product Menu
 *
 * @category  Mtwoe
 * @package   Mtwoe\ProductMenu
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Mtwoe\ProductMenu\Ui\Component\Listing\Column;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Edit url
     */
    const PATH_EDIT   = 'productmenu/products/edit';

    /**
     * Delete url
     */
    const PATH_DELETE = 'productmenu/products/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory
     * @param \Magento\Framework\UrlInterface                              $urlBuilder
     * @param array                                                        $components
     * @param array                                                        $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Prepare data to Product Menu grid
     *
     * @param  array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['edit'] = [
                        'href'  => $this->urlBuilder->getUrl(
                            self::PATH_EDIT, ['entity_id' => $item['entity_id']]
                        ),
                        'label' => __('Edit'),
                    ];
                    $item[$name]['delete'] = [
                        'href'    => $this->urlBuilder->getUrl(
                            self::PATH_DELETE,
                            ['entity_id' => $item['entity_id']]
                        ),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete') . ' ' .
                                $item[\Magento\Catalog\Api\Data\ProductInterface::NAME],
                            'message' => __(
                                'Are you sure you wan\'t to delete a record?'
                            ),
                        ],
                    ];
                }
            }
        }
        return $dataSource;
    }
}
