<?php

class Mage_Sintax_Adminhtml_MyformController extends Mage_Adminhtml_Controller_Action
{
/************************************************************************/
    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }

public function updateproduct() {
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
umask(0);
set_time_limit(0);
ini_set('memory_limit','1024M'); 
$path = Mage::getBaseDir('media') . DS . 'csvfile' . DS; 
	$files = glob($path.'*'); 
foreach($files as $file){ 	
$csv                = new Varien_File_Csv();
$data               = $csv->getData($file); //path to csv
}
array_shift($data);
 foreach($data as $_data){
if($_data[0]){
$product = new Mage_Catalog_Model_Product();
$product
->setWebsiteIds(array(1))
->setAttributeSetId(4)
->setTypeId('simple')
->setCreatedAt(strtotime('now'))
->setSku($_data[0])
    ->setName($_data[30]) 
    ->setWeight($_data[51])
    ->setStatus(1) //product status (1 - enabled, 2 - disabled)
    ->setTaxClassId(1) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
	->setPrice(5)
	->setTaxClassId(0)
	->setName($_data[0])
	->setSatus(1)    
	->setSku('new_'.$_data[0])
		->setDescription($_data[1])
		->setShortDescription($_data[2])   
		->setPr_additionallinetext($_data[3])	
		->setWebText($_data[4])
		->setPr_alias($_data[5])
		->setPr_numberperpallet($_data[6])
		->setPr_numbersalesperunit($_data[7])
		->setPr_numbersalesperunitdevice($_data[8])
		->setPr_grossweight($_data[9])
		->setPr_demovideo($_data[10])
		->setPr_eansalesunit($_data[11])
		->setPr_dangerousgoods($_data[18])
		->setPr_color($_data[19])
		->setPr_foodapprovals($_data[20])
		->setPr_packages($_data[21])
		->setPr_saleonlyinpackages($_data[22])
		->setPr_onlysalesinpack($_data[23])
		->setPr_saleonlyinpallet($_data[24])
		->setPr_supplieritemnumber($_data[25])
		->setPr_food($_data[26])
		->setPr_environmentalcode($_data[27])
		->setWeight($_data[28])
		->setPr_originalitemnumber($_data[29])
		->setPr_productdatasheets($_data[30])
		->setPr_kubicvolumed3salesunit($_data[31])
		->setPr_materialsafetydatasheets($_data[32])
		->setPr_blocked($_data[33])
		->setPr_technicaldatasheet($_data[34])
		->setPr_tariffitem($_data[35])
		->setPr_thicknessmm($_data[36])
		->setPr_thicknessmicrons($_data[37])
		->setPr_unspsc($_data[38])
		->setPr_productpostinggroup($_data[39])
		->setPr_productwidthsalesunit($_data[40])
		->setPr_productheightsalesunit($_data[41])
		->setPr_productlengthsalesunit($_data[42])
		->setPr_webhierarchy($_data[47])
		->setPr_art($_data[48])
		->setPr_format($_data[49])
		->setStockData(array(
                       'use_config_manage_stock' => 1, //'Use config settings' checkbox
                       'manage_stock'=>1, //manage stock
                       'min_sale_qty'=>1, //Minimum Qty Allowed in Shopping Cart
                       'max_sale_qty'=>2, //Maximum Qty Allowed in Shopping Cart
                       'is_in_stock' => 1, //Stock Availability
                       'qty' => $_data[6] //qty
                   )
    ) 
	->setMediaGallery (array('images'=>array (), 'values'=>array ())); //media gallery initialization
	$mediap = Mage::getBaseDir('media');
	if($_data[43]){
	$img = explode('\\',$_data[43]);	$img1 = $img[1];	$img2 = $img[2];
	$fimag = $img1.'/'.$img2;
	$productimage = $_data[43];
    $product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('small_image'), false, false); 
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('thumbnail'), false, false); 
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('image'), false, false);
	}
	if($_data[13]){
	$img = explode('\\',$_data[13]);	$img1 = $img[1];	$img2 = $img[2];
	$fimag = $img1.'/'.$img2;
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('image'), false, false);
	}
	if($_data[14]){
	$img = explode('\\',$_data[14]);	$img1 = $img[1];	$img2 = $img[2];
	$fimag = $img1.'/'.$img2;
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('image'), false, false);
	}	
	if($_data[15]){
	$img = explode('\\',$_data[15]);	$img1 = $img[1];	$img2 = $img[2];
	$fimag = $img1.'/'.$img2;
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('image'), false, false);
	}
	if($_data[16]){	
	$img = explode('\\',$_data[16]);	$img1 = $img[1];	$img2 = $img[2];
	$fimag = $img1.'/'.$img2;
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('image'), false, false);
	}
	if($_data[17]){
	$img = explode('\\',$_data[17]);	$img1 = $img[1];	$img2 = $img[2];
	$fimag = $img1.'/'.$img2;
	$product->addImageToMediaGallery ($mediap.'/import/'.$fimag, array ('image'), false, false);
	}  
	$product->save();
		} 
	} 
}

  /************************************************************************/  
    public function postAction()
    {
	/* Code to delete files from directory media/csvfile */
	   $path = Mage::getBaseDir('media') . DS . 'csvfile' . DS; 
		$files = glob($path.'/*'); // get all file names
		foreach($files as $file){ // iterate files
		unlink($file); // delete file
		}
	/*     */
		if(isset($_FILES['docname']['name']) && $_FILES['docname']['name'] != '')
{
    try
    {      
        $path = Mage::getBaseDir('media') . DS . 'csvfile' . DS;  //desitnation directory    
        $fname = $_FILES['docname']['name']; //file name                       
        $uploader = new Varien_File_Uploader('docname'); //load class
        $uploader->setAllowedExtensions(array('csv')); //Allowed extension for file
        $uploader->setAllowCreateFolders(true); //for creating the directory if not exists
        $uploader->setAllowRenameFiles(false); //if true, uploaded file's name will be changed, if file with the same name already exists directory.
        $uploader->setFilesDispersion(false);
        $uploader->save($path,$fname); //save the file on the specified path
		$this->updateproduct(); 
		  $message = $this->__('Your Product has been Imported successfully.');
         Mage::getSingleton('adminhtml/session')->addSuccess($message);
        
    }
    catch (Exception $e)
    {
      Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    }
}
	
        $this->_redirect('*/*');
    }
	/************************************************************************/
/*********************** function for call  update product function *************************************************/
	public function updateDataAction() {
	$csvfilename = ''.$this->getRequest()->getPost('csv_file');
	//echo $csvfilename;
	
	$this->updateproduct(); 
		  $message = $this->__('Your Product has been updated successfully.');
         Mage::getSingleton('adminhtml/session')->addSuccess($message);
		       $this->_redirect('*/*');
		
}
/************************************************************************/
}