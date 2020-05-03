<?php
namespace MGS\Guestwishlist\Block\Wishlist;

class ListWishlist extends \Magento\Framework\View\Element\Template {
	
	protected function _prepareLayout(){
		
        $pageTitle = __('My Wish List');
		
        if ($pageTitle) {
            $this->pageConfig->getTitle()->set($pageTitle);
        }
		
        return parent::_prepareLayout();
    }
}