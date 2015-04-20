<?php

class Pfay_Test_IndexController extends Mage_Core_Controller_Front_Action
{
   public function indexAction ()
   {
          $this->loadLayout();
          $this->renderLayout();
   }
   public function mamethodeAction ()
   {
     echo 'test mymethod';
    }
	public function saveAction()
 {
	$this->loadLayout();
    $this->renderLayout();
	
   
    $username = ''.$this->getRequest()->getPost('username');
    $email = ''.$this->getRequest()->getPost('email');
    $address = ''.$this->getRequest()->getPost('address');
	
    //on verifie que les champs ne sont pas vide
    if(isset($username)&&($username!='') && isset($email)&&($email!='')
                               && isset($address)&&($address!='') )
   {
      //on cree notre objet et on l'enregistre en base
      $contact = Mage::getModel('test/test');
      $contact->setData('username',$username);
      $contact->setData('email',$email);
      $contact->setData('address',$address);
	 
      $contact->save();
      $this->_redirect('test/index/index');
   }
   //on redirige l’utilisateur vers la méthode index du controller indexController
   //de notre module <strong>test</strong>
  
}

	public function editAction()
 {
 
 $id = ''.$this->getRequest()->getParam('id');

  
	$this->loadLayout();
    $this->renderLayout();
	
   
    
	
    //on verifie que les champs ne sont pas vide
    if(!empty($this->getRequest()->getPost()) )
   {
  
  
   $contact = Mage::getModel('test/test')->load($id);
   $username = ''.$this->getRequest()->getPost('username');
    $email = ''.$this->getRequest()->getPost('email');
    $address = ''.$this->getRequest()->getPost('address');
      //on cree notre objet et on l'enregistre en base
      
	  $contact->setData('username',$username);
      $contact->setData('email',$email);
      $contact->setData('address',$address);
	  $message = $this->__('Data Saved Successful');
    Mage::getSingleton('core/session')->addSuccess($message);
      $contact->save();
      $this->_redirect('test/index/index');
   }else{
   
   
   
   /* $collection = Mage::getModel('test/test')->load($id);
   return Mage::app()->getRequest()->getBlockName();;  */
}


}
public function deleteAction()
 {
 
 $id = ''.$this->getRequest()->getParam('id');

  
	$this->loadLayout();
    $this->renderLayout();
	try{ 
     Mage::getModel("test/test")->load( $id  )->delete();
	  $message = $this->__('Deleted Record');
    Mage::getSingleton('core/session')->addSuccess($message);
	$this->_redirect('test/index/index');
	}catch(Exception $e){
	echo "Delete failed"; 
	} 
	
}

}
