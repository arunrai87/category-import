<?php

class Mage_Sintax_Adminhtml_MyformController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout()->renderLayout();
	}
	public function importCategory() {
		$path = Mage::getBaseDir('media') . DS . 'csvfile'; 
		$files = glob($path.'/*'); // get all file names
		if($files){
			foreach($files as $file){ // iterate files			
				$csv  = 	new Varien_File_Csv();
				$data = 	$csv->getData($file); //path to csv
		}		
		array_shift($data);
		foreach($data as $_data){
			// echo '<pre>';
			// print_r($_data);
			// echo '<pre>';
			//Parent category creation First level
			$ParentCategory =  utf8_encode($_data[0]);
			$getCategoryIfExist = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$ParentCategory);
			$catData = $getCategoryIfExist->getData();
			$catcount  = count($catData);
			if($catcount==0 && !empty($ParentCategory))
			{	
				$category = Mage::getModel('catalog/category');
				$category->setName($ParentCategory);
				$category->setUrlKey($ParentCategory);
				$category->setMetaTitle($ParentCategory);
				$category->setIsActive(1);
				$category->setIncludeInMenu(0);
				$category->setDisplayMode('PRODUCTS');
				$category->setIsAnchor(1); //for active achor
				$category->setStoreId(Mage::app()->getStore()->getId());
				$parentCategory = Mage::getModel('catalog/category')->load(2);
				$category->setPath($parentCategory->getPath());
				$category->save();
			}
			//Child category creation Second level
			global $childCategory;
			$childCategory = utf8_encode($_data[1]);
			if($childCategory)
			{
				$childCategoryIfExist = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$childCategory);
				$childCategoryData = $childCategoryIfExist->getData();
				if(!$childCategoryData)
				{
					$getParentCateData = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$ParentCategory);
					$catData = array();
					$catData = $getParentCateData->getData();
					if(!empty($catData)){
					$ParentCategoryId = $catData[0]['entity_id'];			
					$category = Mage::getModel('catalog/category');
					$category->setName($childCategory);
					$category->setUrlKey($childCategory);
					$category->setMetaTitle($childCategory);
					$category->setIsActive(1);
					$category->setIncludeInMenu(0);
					$category->setDisplayMode('PRODUCTS');
					$category->setIsAnchor(1); //for active achor
					$category->setStoreId(Mage::app()->getStore()->getId());
					$parentCategory = Mage::getModel('catalog/category')->load($ParentCategoryId);
					$category->setPath($parentCategory->getPath());
					$category->save();
					}		
				} 
			}	
			//Sub-Child category creation Third level
			global $subChildCategory;
			$subChildCategory = utf8_encode($_data[2]);
			if($subChildCategory){
				$subChildCategoryIfExist = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$subChildCategory);
				$subChildCategoryData = $subChildCategoryIfExist->getData();
				if(!$subChildCategoryData) 
				{
					$getChildCateData = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$childCategory);
					$childCatData = array();
					$childCatData = $getChildCateData->getData();
					// echo '<pre>';
					// print_r($childCatData);
					// echo '<pre>';
					// die;
					if(!empty($catData))
					{
						$childParentCategoryId = $childCatData[0]['entity_id'];			
						$category = Mage::getModel('catalog/category');
						$category->setName($subChildCategory);
						$category->setUrlKey($subChildCategory);
						$category->setMetaTitle($subChildCategory);
						$category->setIsActive(1);
						$category->setIncludeInMenu(0);
						$category->setDisplayMode('PRODUCTS');
						$category->setIsAnchor(1); //for active achor
						$category->setStoreId(Mage::app()->getStore()->getId());
						$subChildCategory = Mage::getModel('catalog/category')->load($childParentCategoryId);
						$category->setPath($subChildCategory->getPath());
						$category->save();
					}		
				} 
			}
		} // endforeach
		} //endif
	}
	public function postAction()
	{
		 // Code to delete files from directory media/csvfile 
		   $path = Mage::getBaseDir('media') . DS . 'csvfile' . DS; 
			$files = glob($path.'/*');
			foreach($files as $file){ 
			unlink($file); 
			}

			if(isset($_FILES['docname']['name']) && $_FILES['docname']['name'] != '')
			{
				try
				{      
					$path = Mage::getBaseDir('media') . DS . 'csvfile' . DS;  
					$fname = $_FILES['docname']['name'];                       
					$uploader = new Varien_File_Uploader('docname'); 
					$uploader->setAllowedExtensions(array('csv')); 
					$uploader->setAllowCreateFolders(true); 
					$uploader->setAllowRenameFiles(false); 
					$uploader->setFilesDispersion(false);
					$uploader->save($path,$fname);
					$this->importCategory(); 
					$message = $this->__('Your Category has been Imported successfully.');
					Mage::getSingleton('adminhtml/session')->addSuccess($message);
				}
				catch (Exception $e)
				{
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				}
			}
		
			$this->_redirect('*/*');
	}
}