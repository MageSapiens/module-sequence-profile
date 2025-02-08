<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Sapiens\SequenceProfile\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\SalesSequence\Model\MetaFactory;
use Magento\SalesSequence\Model\ResourceModel\Meta;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class to build edit and delete link for each item.
 */
class Scope extends Column
{
    /**
     * @var MetaFactory
     */
    protected MetaFactory $metaFactory;

    /**
     * @var Meta
     */
    protected Meta $metaResourceModel;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param MetaFactory $metaFactory
     * @param Meta $metaResourceModel
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface      $context,
        UiComponentFactory    $uiComponentFactory,
        MetaFactory           $metaFactory,
        Meta                  $metaResourceModel,
        StoreManagerInterface $storeManager,
        array                 $components = [],
        array                 $data = []
    ) {
        $this->metaFactory = $metaFactory;
        $this->metaResourceModel = $metaResourceModel;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $metaId = $item['meta_id'] ?? null;
                if ($metaId) {
                    $meta = $this->metaFactory->create();
                    $this->metaResourceModel->load($meta, $metaId);
                    $store = $this->storeManager->getStore($meta->getData('store_id'));
                    $item[$this->getData('name')] = $store->getName();
                    $item['profile'] = $this->getEntityTypeTitle($meta->getData('entity_type'));
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get entity type title
     *
     * @param string|null $type
     * @return string
     */

    private function getEntityTypeTitle(string $type = null): string
    {
        switch ($type) {
            case 'order':
                $title = __('Order');
                break;
            case 'invoice':
                $title = __('Invoice');
                break;
            case 'creditmemo':
                $title = __('Credit Memo');
                break;
            case 'shipment':
                $title = __('Shipment');
                break;
            default:
                $title = __('%1', $type);
                break;
        }
        return $title;
    }
}
