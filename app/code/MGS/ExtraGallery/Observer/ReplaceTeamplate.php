<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
 
namespace MGS\ExtraGallery\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ReplaceTeamplate implements ObserverInterface {
	
    const XML_CONFIG_TYPE = 'extragallery/general/glr_type';
	
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
	
	/**
     * @var \Magento\Framework\App\Request\Http
     */
	protected $request;

    /**
     * AdminFailed constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Framework\App\Request\Http $request
    )
    {
        $this->scopeConfig = $scopeConfig;
		$this->_request = $request;
    }
    
    public function execute(Observer $observer) {
        
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		$type = $this->scopeConfig->getValue(self::XML_CONFIG_TYPE, $storeScope);
		
		$action = $this->_request->getFullActionName();
		
		$layout = $observer->getLayout();
		$blockProductGallery = $layout->getBlock('product.info.media.image');
		
		if($blockProductGallery){
			$layout->unsetElement('product.info.media.image');
			if($type == 2 || $type == 6){
				$layout->unsetElement('product.info.extra.media.image');
				if($action != 'mgs_quickview_catalog_product_view'){
					$layout->unsetElement('product.info.media');
				}
			}else {
				$layout->unsetElement('product.info.extra.media.image.type');
			}
		}
		
		return $this;
    }
}
