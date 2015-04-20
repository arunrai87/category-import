<?php
error_reporting(E_ALL | E_STRICT);
$mageFilename = 'app/Mage.php';
require_once $mageFilename;
$app = Mage::app('admin'); 
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
ini_set('memory_limit', '600M');
ini_set('max_execution_time', 1800);
umask(0);
Mage::app('admin');
/************ Get file from database  **************/
		$path = Mage::getBaseDir('media') . DS . 'catcsvfile'; 
		$files = glob($path.'/*'); // get all file names
		if($files){
			foreach($files as $file){ // iterate files			
					$csv  = 	new Varien_File_Csv();
					$data = 	$csv->getData($file); //path to csv
								}		
	array_shift($data);
 foreach($data as $_data){
/*****************  Prent category creation *****************/
			/*****************  Prent category creation *****************/
			$Pcat =  utf8_encode($_data[37]);
			$getcategory = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$Pcat);
			$catData = $getcategory->getData();
			$catcount  = count($catData);
				if($catcount==0 && !empty($Pcat))
			{		$category = Mage::getModel('catalog/category');
					$category->setName($Pcat);
					$category->setUrlKey($Pcat);
					$category->setMetaTitle($Pcat);
					$category->setIsActive(1);
					$category->setDisplayMode('PRODUCTS');
					$category->setIsAnchor(1); //for active achor
					$category->setStoreId(Mage::app()->getStore()->getId());
					$parentCategory = Mage::getModel('catalog/category')->load(2);
					$category->setPath($parentCategory->getPath());
					$category->save();
		}
/*    Child category creation             **********************/
			global $childcat;
			 $childcat = utf8_encode($_data[38]);
			$pgetcategory = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$childcat);
			$pcatData = $pgetcategory->getData();
			if(!$pcatData) {
			 $getcategory2 = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$Pcat);
			 $catData2 = array();
			$catData2 = $getcategory2->getData();
			if(!empty($catData2)){
			$ParentCategoryId2 = $catData2[0]['entity_id'];			
					$category = Mage::getModel('catalog/category');
					$category->setName($childcat);
					$category->setUrlKey($childcat);
					$category->setMetaTitle($childcat);
					$category->setIsActive(1);
					$category->setDisplayMode('PRODUCTS');
					$category->setIsAnchor(1); //for active achor
					$category->setStoreId(Mage::app()->getStore()->getId());
					$parentCategory = Mage::getModel('catalog/category')->load($ParentCategoryId2);
					$category->setPath($parentCategory->getPath());
					$category->save();
			}		
			}
	}
}
else
{
echo 'file not found';
}
?>