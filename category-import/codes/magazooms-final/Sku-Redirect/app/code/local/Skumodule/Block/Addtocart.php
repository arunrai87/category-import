<?php
/*  app/code/local/Oakwood/Skumodule/Block/  

 * @package    Oakwood_Skumodule

 * @version    0.1.0

 * @author     Arunendra Pratap Rai <bablu_rai19@yahoo.com> 

 */
	
class Oakwood_Skumodule_Block_Addtocart extends Mage_Core_Block_Template
{
     public function addtocart()
     {
		$product = Mage::getModel('catalog/product');
		$productid = $product->getIdBySku('91298c ');
		$productDetail = $product->load($productid);
		$producturl = $product->getProductUrl();
		Mage::app()->getFrontController()->getResponse()->setRedirect($producturl);
	     }
}