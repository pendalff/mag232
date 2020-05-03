<?php
/**
 * @copyright Copyright (c) 2018 www.magesolution.com
 */

namespace MGS\Guestwishlist\Block\Js;
use Magento\Framework\Json\Helper\Data as jsonHelper;

use Magento\Framework\View\Element\Template\Context;
use Tigren\Ajaxwishlist\Helper\Data;

class MainJs extends \Magento\Framework\View\Element\Template
{

	/**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;
	
	/**
     * Constructor.
     * 
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        Context $context,
		jsonHelper $jsonHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
		$this->jsonHelper = $jsonHelper;
    }

    public function getGuestwishlistOptions()
    {
        $respons = array(
            'updateCartUrl' => '123',
            'redirectCartUrl' => '456'
        );
		
        return $this->jsonHelper->jsonEncode($respons);
    }
}