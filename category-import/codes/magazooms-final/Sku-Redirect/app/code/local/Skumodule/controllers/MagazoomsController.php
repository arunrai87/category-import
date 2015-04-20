<?php
/*  app/code/local/Oakwood/Skumodule/controllers/  

 * @package    Oakwood_Skumodule

 * @version    0.1.0

 * @author     Arunendra Pratap Rai <bablu_rai19@yahoo.com> 

 */
			
class  Oakwood_Skumodule_MagazoomsController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
	
		$sku = ''.$this->getRequest()->getParam('sku');	
	
		if($sku && !empty($sku ))
		{
		$product = Mage::getModel('catalog/product');
		$productid = $product->getIdBySku($sku);
		$productDetail = $product->load($productid);
		$producturl = $product->getProductUrl();		
		$column = array('sku','description','weight','price','isInStock','imageUrl');
		if($productid && !empty($productid)){
				$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root/>');
				header('Content-type: text/xml');
				$dox = new DomDocument('1.0','UTF-8');
				$dox->formatOutput = true;
				$root = $dox->createElement('root');
				$record = $dox->createElement('record');
				/*             sku    */
				$field = $dox->createElement('sku');
				$fieldTxt= $dox->createTextNode(trim($product->getSku()));
				$field->appendChild($fieldTxt);
				$record->appendChild($field);		
/*        =============================          description     ====================             */	
				$field = $dox->createElement('description');
				$des = htmlspecialchars(trim($product->getDescription()));
				$des2 = html_entity_decode($des);
				$fieldTxt= $dox->createTextNode(substr($des2,0,254));
				$field->appendChild($fieldTxt);
				$record->appendChild($field);			
/*        =============================          wightt     ====================             */	
				$field = $dox->createElement('weight');
				$fieldTxt= $dox->createTextNode(trim($product->getWeight()));
				$field->appendChild($fieldTxt);
				$record->appendChild($field);			
/*        =============================          end      ====================             */
	
/*        =============================          price     ====================             */	
				$field = $dox->createElement('price');
				$fieldTxt= $dox->createTextNode(trim($product->getPrice()));
				$field->appendChild($fieldTxt);
				$record->appendChild($field);			
/*        =============================          price     ====================             */			
/*        =============================          stock info     ====================             */	
				$field = $dox->createElement('available');
				if($product->getStockItem()->getIsInStock() ==1)
					{
					$fieldTxt= $dox->createTextNode('In Stock');
				}
				else
				{
				$fieldTxt= $dox->createTextNode('Out of Stock');
				}
				$field->appendChild($fieldTxt);
				$record->appendChild($field);			
/*        =============================          image     ====================             */	
				$field = $dox->createElement('image');
				$fieldTxt= $dox->createTextNode(trim($product->getImageUrl()));
				$field->appendChild($fieldTxt);
				$record->appendChild($field);			
/*        =============================          record     ====================             */		
				$root->appendChild($record);
				$dox->appendChild($root);
				$xml_string = $dox->saveXML();
				echo $xml_string;
					 die;
						
			}
			else 
			{
				$message = "No Product is found with this sku please try another";
				 Mage::getSingleton('core/session')->addError($message);
				 $home_url = Mage::helper('core/url')->getHomeUrl();
				 Mage::app()->getFrontController()->getResponse()->setRedirect($home_url);
		
			}
	}
	else 
		{
		$message = "No Product is found with this sku please try another";
		 Mage::getSingleton('core/session')->addError($message);
		 $home_url = Mage::helper('core/url')->getHomeUrl();
		 Mage::app()->getFrontController()->getResponse()->setRedirect($home_url);
		
		}
	}

}