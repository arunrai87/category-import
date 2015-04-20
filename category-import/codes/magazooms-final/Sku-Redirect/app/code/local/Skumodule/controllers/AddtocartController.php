<?php
/*  app/code/local/Oakwood/Skumodule/controllers/  

 * @package    Oakwood_Skumodule

 * @version    0.1.0

 * @author     Arunendra Pratap Rai <bablu_rai19@yahoo.com> 

 */
			
class  Oakwood_Skumodule_AddtocartController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$sku = ''.$this->getRequest()->getParam('sku');
		$product = Mage::getModel('catalog/product');
		$productid = $product->getIdBySku($sku);
		if($productid)
		{
		$qty = '1'; 
		$_product = Mage::getModel('catalog/product')->load($productid);
		$params = array('qty' => $qty);
		$cart = Mage::getModel('checkout/cart');
		$cart->init();
		$cart->addProduct($_product,$params);
		$cart->save();
		Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		$message = $this->__('Custom message: %s was successfully added to your shopping cart.', $_product->getName());
		Mage::getSingleton('checkout/session')->addSuccess($message);
		 $CartUrl = Mage::getUrl('checkout/cart');
		 Mage::app()->getFrontController()->getResponse()->setRedirect($CartUrl);
		 }
		 else
		 {
		 $message = "No Product is found with this SKU please try another";
		 Mage::getSingleton('core/session')->addError($message);
		 $home_url = Mage::helper('core/url')->getHomeUrl();
		 Mage::app()->getFrontController()->getResponse()->setRedirect($home_url);	
		 }
    }
	public function addtocart()
	{
		echo 'hello i am add to cart';
		die;
	
	}

}