<?php

$mageFilename = 'app/Mage.php';
require_once $mageFilename;
$app = Mage::app('admin'); 
ini_set('memory_limit', '600M');
ini_set('max_execution_time', 1800);
ini_set('display_errors', 1);
umask(0);
Mage::app('admin');
$mediap = Mage::getBaseDir('media');
$imagepath = Mage::getBaseDir('media') . DS . 'import' . DS;
			$path = Mage::getBaseDir('media') . DS . 'csvfile'; 
		$files = glob($path.'/*'); // get all file names
		if($files[0]){
			foreach($files as $file){ // iterate files			
					$csv  = 	new Varien_File_Csv();
					$data = 	$csv->getData($file); //path to csv
				}
	
	$totalrows = count($data);
	array_shift($data);
 foreach($data as $_data){
		$product1 = Mage::getModel('catalog/product');
		$prdid = $product1->getIdBySku('final-'.$_data[0]);
			if(empty($prdid) && !empty($_data[0])){
			 $product = Mage::getModel('catalog/product');
				$product
				->setWebsiteIds(array(1))
			->setAttributeSetId(42)
			->setTypeId('simple')
			->setCreatedAt(strtotime('now'))
				->setName(utf8_encode($_data[1]))
				->setStatus(1) //product status (1 - enabled, 2 - disabled)
				->setTaxClassId(1) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
				->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
			->setPrice($_data[39])
				->setSku('final-'.$_data[0])
					->setDescription(utf8_encode($_data[4]))
					->setShortDescription(utf8_encode($_data[2]).utf8_encode($_data[3])) 					
					->setPrAlias(utf8_encode($_data[5]))
					->setPrNumberperpallet($_data[6])
					->setPrNumbersalesperunit($_data[7])
					->setPrNumbersalesperunitdevice($_data[8])
					->setPrGrossweight($_data[9])
					->setPrDemovideo(utf8_encode($_data[10]))
					->setPrEansalesunit($_data[11])
					->setPrDangerousgoods($_data[18])
					->setPrColor($_data[19])
					->setPrFoodapprovals($_data[20])
					->setPrPackages($_data[21])
					->setPrSaleonlyinpackages($_data[22])
					->setPrOnlysalesinpack($_data[23])
					->setPrSaleonlyinpallet($_data[24])
					->setPrSupplieritemnumber($_data[25])
					->setPrFood($_data[26])
					->setPrEnvironmentalcode($_data[27])
					->setWeight($_data[28])
					->setPrOriginalitemnumber($_data[29])
					->setPrProductdatasheets($_data[30])
					->setPrKubicvolumed3salesunit($_data[31])
					->setPrMaterialsafetydatasheets($_data[32])
					->setPrBlocked($_data[33])
					->setPrTechnicaldatasheet($_data[34])
					->setPrTariffitem($_data[35])
					->setPrThicknessmm($_data[36])
					->setPrThicknessmicrons($_data[37])
					->setPrUnspsc($_data[38])
					->setPrProductpostinggroup($_data[39])
					->setPrProductwidthsalesunit($_data[40])
					->setPrProductheightsalesunit($_data[41])
					->setPrProductlengthsalesunit($_data[42])					
					->setPrFormat($_data[45])
					->setStockData(array(
								   'is_in_stock' => 1, //Stock Availability
								   'qty' => $_data[27] //qty
							   )
					)
	->setMediaGallery (array('images'=>array (), 'values'=>array ())); 	
		if($_data[0]){
				$imagename = $_data[0].'.JPG';
				$prdimage = $imagepath.$imagename;			
	if(file_exists($prdimage)){
	$product->addImageToMediaGallery ($prdimage, array ('small_image','image','thumbnail'), false, false); 
					}
				}					
if(!empty($_data[38])){
	$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',utf8_encode($_data[38]));
    $cat_det=$category->getData();      
	$category_id = $cat_det[0][entity_id];
	$product->setCategoryIds($category_id);
}
else if(!empty($_data[37])){
					$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',utf8_encode($_data[37]));
    $cat_det=$category->getData();      
	$category_id = $cat_det[0][entity_id];
	$product->setCategoryIds($category_id);
}
				$product->save();	

										
		} 	
		else{
			$product2 = Mage::getModel('catalog/product');
			$pid = intval($product2->getIdBySku('final-'.$_data[0]));
			$savep = Mage::getModel('catalog/product');
			$_product = $savep->load($pid);			
			$_product
			->setPrice($_data[39])
					->setDescription(utf8_encode($_data[4]))
		->setShortDescription(utf8_encode($_data[2]).utf8_encode($_data[3]))			
					->setPrAlias(utf8_encode($_data[5]))
					->setPrNumberperpallet($_data[6])
					->setPrNumbersalesperunit($_data[7])
					->setPrNumbersalesperunitdevice($_data[8])
					->setPrGrossweight($_data[9])
					->setPrDemovideo(utf8_encode($_data[10]))
					->setPrEansalesunit($_data[11])
					->setPrDangerousgoods($_data[18])
					->setPrColor($_data[19])
					->setPrFoodapprovals($_data[20])
					->setPrPackages($_data[21])
					->setPrSaleonlyinpackages($_data[22])
					->setPrOnlysalesinpack($_data[23])
					->setPrSaleonlyinpallet($_data[24])
					->setPrSupplieritemnumber($_data[25])
					->setPrFood($_data[26])
					->setPrEnvironmentalcode($_data[27])
					->setWeight($_data[28])
					->setPrOriginalitemnumber($_data[29])
					->setPrProductdatasheets($_data[30])
					->setPrKubicvolumed3salesunit($_data[31])
					->setPrMaterialsafetydatasheets($_data[32])
					->setPrBlocked($_data[33])
					->setPrTechnicaldatasheet($_data[34])
					->setPrTariffitem($_data[35])
					->setPrThicknessmm($_data[36])
					->setPrThicknessmicrons($_data[37])
					->setPrUnspsc($_data[38])
					->setPrProductpostinggroup($_data[39])
					->setPrProductwidthsalesunit($_data[40])
					->setPrProductheightsalesunit($_data[41])
					->setPrProductlengthsalesunit($_data[42])					
					->setPrFormat($_data[45])
					->setStockData(array(
								   'is_in_stock' => 1, //Stock Availability
								   'qty' => $_data[27] //qty
							   )
					);
				/*	->setMediaGallery (array('images'=>array (), 'values'=>array ())); 	
		if($_data[0]){
				$imagename = $_data[0].'.JPG';
				$prdimage = $imagepath.$imagename;			
	if(file_exists($prdimage)){
	$_product->addImageToMediaGallery ($prdimage, array ('small_image','image','thumbnail'), false, false); 
					}
				}*/
	if(!empty($_data[38])){
	$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',utf8_encode($_data[38]));
    $cat_det=$category->getData();      
	$category_id = $cat_det[0][entity_id];
	$_product->setCategoryIds($category_id);
	}
else if(!empty($_data[37])){
	$category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',utf8_encode($_data[37]));
    $cat_det=$category->getData();      
	$category_id = $cat_det[0][entity_id];
	$_product->setCategoryIds($category_id);
					}
			$_product->save();	
			
	   }
} 

}

else
{		
			$path = Mage::getBaseDir('media') . DS . 'csvfile' . DS; 
			$files = glob($path.'/*'); // get all file names
			foreach($files as $file){ // iterate files
				#unlink($file); // delete fil
				echo 'deleted file';
				}

}
?>