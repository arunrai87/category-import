<?php
class Pfay_Test_Block_Add extends Mage_Core_Block_Template
{
     public function methodblockg()
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
}