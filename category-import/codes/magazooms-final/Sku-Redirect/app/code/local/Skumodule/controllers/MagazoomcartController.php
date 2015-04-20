<?php
/*  app/code/local/Oakwood/Skumodule/controllers/  

 * @package    Oakwood_Skumodule

 * @version    0.1.0

 * @author     

 */
			
class Oakwood_Skumodule_MagazoomcartController extends Mage_Core_Controller_Front_Action
{
  public function indexAction()
    { 	
	$sessionid2 = ''. $this->getRequest()->getParam('sid');
	$psku = ''.$this->getRequest()->getParam('sku');
	$pqty = ''.$this->getRequest()->getParam('qty');	
	if($sessionid2)
	{	
	$Productskus = str_replace('+',' ',$psku);
	$Pskus = explode(' ',$Productskus);
	$Productqtys = str_replace('+',' ',$pqty);
	$Pqtys = explode(' ',$Productqtys);
	$product = Mage::getModel('catalog/product');
	$i =0;
	foreach($Pskus as $_Pskus){
		$productid = $product->getIdBySku($_Pskus);
		$_product = Mage::getModel('catalog/product')->load($productid);
		$params = array('qty' => $Pqtys[$i]);
		$cart = Mage::getModel('checkout/cart');
		$cart->init();
		$cart->addProduct($_product,$params);
		$i++;
		}
		$cart->save();
		Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		$message = $this->__('Custom message: %s was successfully added to your shopping cart.', $_product->getName());
		Mage::getSingleton('checkout/session')->addSuccess($message);
		 $CartUrl = Mage::getUrl('checkout/cart');
		 Mage::app()->getFrontController()->getResponse()->setRedirect($CartUrl);
	}
	else
	{	
	$data = trim(file_get_contents('php://input'));		
	preg_match_all("#<sku.*?>([^<]+)</sku>#", $data, $foo);
	preg_match_all("#<qty.*?>([^<]+)</qty>#", $data, $foobar);
	$sessionid = $this->getTextBetweenTags($data,"sessionID");
	$fsku = $foo[1];	
	$abb = implode(' ',$fsku);
	$sku = str_replace(' ','+',$abb);
	$fqty = $foobar[1];		
	$abb2 = implode(' ',$fqty);
	$qty = str_replace(' ','+',$abb2);
		$home_url = Mage::helper('core/url')->getHomeUrl();
		$CartUrl = $home_url.'skumodule/magazoomcart';
		$finalurl = $CartUrl.'?sid='.$sessionid.'&sku='.$sku.'&qty='.$qty;
		echo $finalurl;
	}
	
    }
	
public function getTextBetweenTags($string, $tagname) {
     $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}
  public function showAction()
  {
$uri =  $_SERVER["REQUEST_URI"]; //it will print full url
$uriArray = explode('/', $uri); //convert string into array with explode
$id = explode('?', $uriArray[2]);;
var_dump($id);
	 die;'</pre>';
         }
}