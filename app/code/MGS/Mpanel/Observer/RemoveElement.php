<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
 
namespace MGS\Mpanel\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RemoveElement implements ObserverInterface {
    
    const XML_CONFIG_SKU = 'mpanel/product_details/sku';
	
    const XML_CONFIG_SHORT_DESCRIPTION = 'mpanel/product_details/short_description';
	
    const XML_CONFIG_REVIEW_SUMMARY = 'mpanel/product_details/reviews_summary';
	
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * AdminFailed constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }
    
    public function execute(Observer $observer) {
        
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		
        /** @var \Magento\Framework\View\Layout $layout */

        $layout = $observer->getLayout();
        
        $blockProduct = $layout->getBlock('product.info');
        
        if($blockProduct) {
			$showSku = $this->scopeConfig->getValue(self::XML_CONFIG_SKU, $storeScope);
			$showShortDescription = $this->scopeConfig->getValue(self::XML_CONFIG_SHORT_DESCRIPTION, $storeScope);
			$showReview = $this->scopeConfig->getValue(self::XML_CONFIG_REVIEW_SUMMARY, $storeScope);
			
			if(!$showSku){
				$layout->unsetElement('product.info.sku');
			}
			if(!$showShortDescription){
				$layout->unsetElement('product.info.overview');
			}
			if(!$showReview){
				$layout->unsetElement('product.info.review');
			}
        }
    }
}
