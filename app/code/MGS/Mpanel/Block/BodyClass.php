<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MGS\Mpanel\Block;

/**
 * Main contact form block
 */
class BodyClass extends \Magento\Framework\View\Element\Template {
	
	protected $_themeHelper;
	
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\MGS\Mpanel\Helper\Data $themeHelper,
		array $data = []
	) 
	{
		$this->_themeHelper = $themeHelper;
		parent::__construct($context, $data);
	}
	
	protected function _prepareLayout()
    {
		$this->pageConfig->addBodyClass('use-' . $this->_themeHelper->getHeaderClass());
		
		$ratio = $this->_themeHelper->getStoreConfig('mpanel/catalog/picture_ratio');
		$this->pageConfig->addBodyClass('ratio-' . $ratio);
		
		if($this->_themeHelper->getStoreConfig('mgstheme/header/absolute_header')){
			$this->pageConfig->addBodyClass('absolute-header');
		}
		
		if($this->_themeHelper->getStoreConfig('mgstheme/general/lazy_load')){
			$this->pageConfig->addBodyClass('lazy-load-img');
		}
		
		if($this->_themeHelper->getStoreConfig('mpanel/minicart/minicart_type') == 2){
			$this->pageConfig->addBodyClass('sidebar-cart-type');
		}else {
			$this->pageConfig->addBodyClass('dropdown-cart-type');
		}
		
        return parent::_prepareLayout();
    }
}

