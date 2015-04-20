<?php
class Pfay_Test_Block_Monblock extends Mage_Core_Block_Template
{
     public function methodblock()
     {
       
        $retour='';
       
     $collection = Mage::getModel('test/test')->getCollection()
                                 ->setOrder('id','asc');
 		
        foreach($collection as $data)
        {
             $retour .= $data->getData('username').' '.$data->getData('email')
                     .' '.$data->getData('address').'<br />';
         }
      Mage::getSingleton('adminhtml/session')->addSuccess('Cool Ca marche !!');
         return $collection;
     }
	  public function methodblock2()
     {
$id = $this->getRequest()->getParam('id');
		$collection = Mage::getModel('test/test')->load($id);
		return $collection; 
	 }
}