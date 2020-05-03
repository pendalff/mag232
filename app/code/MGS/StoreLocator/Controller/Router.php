<?php 

namespace MGS\StoreLocator\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
	protected $actionFactory;
	
	protected $objectManager;
	
	public function __construct (
		\Magento\Framework\App\ActionFactory $actionFactory, 
		\Magento\Framework\ObjectManagerInterface $objectManager
    ) 
	{
        $this->actionFactory = $actionFactory;
		$this->objectManager = $objectManager;
		
    }
	
	public function getModel(){
		return $this->objectManager -> create ('MGS\StoreLocator\Model\Store');
		
	}
	
	public function  match(\Magento\Framework\App\RequestInterface $request) {
		$urlKey = trim($request->getPathInfo(), '/' );
		
		$_urlKey = explode ('/', $urlKey);
		
		if($_urlKey[0] == 'storelocator') {
			if(isset($_urlKey[1])) {
				$storeUrlKey = $_urlKey[1];
				
				$localtorUrlKey = $this->getModel()->getCollection()
								->addFieldToFilter ('status', 1)
								->addFieldToFilter ('url_key', $storeUrlKey)
								->getFirstItem() ;
								
				$request->setModuleName('storelocator')->setControllerName('index')->setActionName('view')->setParam('id', $localtorUrlKey->getId());

				$request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $urlKey);
				return $this->actionFactory->create(
					'Magento\Framework\App\Action\Forward',
					['request' => $request]
				);
				
			}
			
			return false;
		}
		
		return false; 
		
	}
	
	
	
}
