<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Sapiens\OrderPrefix\Model\Profile\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\SalesSequence\Model\Meta;
use Magento\Store\Model\StoreManagerInterface;
use Sapiens\OrderPrefix\Model\ResourceModel\Meta\Collection;
use Sapiens\OrderPrefix\Model\ResourceModel\Meta\CollectionFactory;

/**
 * Class IsActive
 */
class Sequence implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CollectionFactory     $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        /** @var Collection $availableOptions */
        $entitiesMeta = $this->collectionFactory->create();
        $options = [];
        /** @var Meta $meta */
        foreach ($entitiesMeta as $meta) {
            $options[] = [
                'label' => $this->getEntityTypeTitle($meta->getData('entity_type'), $meta->getData('store_id')),
                'value' => $meta->getData('meta_id'),
            ];
        }
        return $options;
    }

    private function getEntityTypeTitle(string $type = null, int $storeId = null): string
    {
        $store = $this->storeManager->getStore($storeId);
        switch ($type) {
            case 'order':
                $title = __('Order (%1)', $store->getName());
                break;
            case 'invoice':
                $title = __('Invoice (%1)', $store->getName());
                break;
            case 'creditmemo':
                $title = __('Credit Memo (%1)', $store->getName());
                break;
            case 'shipment':
                $title = __('Shipment (%1)', $store->getName());
                break;
            default:
                $title = __('%1 (%2)', $type, $store->getName());
                break;
        }
        return $title;
    }
}
