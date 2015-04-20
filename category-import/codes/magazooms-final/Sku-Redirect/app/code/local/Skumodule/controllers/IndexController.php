<?php
/*  app/code/local/Oakwood/Skumodule/controllers/  

 * @package    Oakwood_Skumodule

 * @version    0.1.0

 * @author     Arunendra Pratap Rai <bablu_rai19@yahoo.com> 

 */
			
class  Oakwood_Skumodule_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		/*echo 'ddd';
		die;*/
		$sku = ''.$this->getRequest()->getParam('sku');
		$product = Mage::getModel('catalog/product');
		$productid = $product->getIdBySku($sku);
		if($productid)
		{
		$productDetail = $product->load($productid);
		$producturl = $productDetail->getProductUrl();
		Mage::app()->getFrontController()->getResponse()->setRedirect($producturl);
		}
		else 
		{
			$message = "No Product is found with this sku please try another";
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