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
			//Parent category creation First level
			$ParentCategory =  utf8_encode($_data[0]);
			$getCategoryIfExist = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$ParentCategory)->addFieldToFilter('level', array('eq' => '2'));
			$catData = $getCategoryIfExist->getData();
			$catcount  = count($catData);
			if($catcount == 0 && !empty($ParentCategory))
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
			if(!empty($childCategory))
			{	// get parent menus id
				$getCategoryIfExist2 = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$ParentCategory)->addFieldToFilter('level', array('eq' => '2'));
				$catData2 = $getCategoryIfExist2->getData();	
				Mage::getSingleton('core/session')->setSecendlevel($catData2[0]['entity_id']);
				$childCategoryIfExist = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$childCategory)->addFieldToFilter('level', array('eq' => '3'))
				->addFieldToFilter('parent_id', array('eq' => $catData2[0]['entity_id']))	;
				$childCategoryData = $childCategoryIfExist->getData();				
				if($childCategoryData)
				{						
					// get all parent menu's ids
					$children = Mage::getModel('catalog/category')->load($catData2[0]['entity_id'])->getChildrenCategories();
					$arr = array();
					foreach ($children as $category) {
					$arr[] =  $category->getId();
					}						
					if(!in_array($childCategoryData[0]['entity_id'],$arr)){								
						$category = Mage::getModel('catalog/category');
						$category->setName($childCategory);
						$category->setUrlKey($childCategory);
						$category->setMetaTitle($childCategory);
						$category->setIsActive(1);
						$category->setIncludeInMenu(0);
						$category->setDisplayMode('PRODUCTS');
						$category->setIsAnchor(1); //for active achor
						$category->setStoreId(Mage::app()->getStore()->getId());
						$parentCategory = Mage::getModel('catalog/category')->load($catData2[0]['entity_id']);
						$category->setPath($parentCategory->getPath());
						$category->save();
							
					}
				}
				else{
					$getParentCateData = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$ParentCategory)->addFieldToFilter('level', array('eq' => '2'));
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
			if(!empty($subChildCategory)){
				// get parent menus id
				$getSession = Mage::getSingleton('core/session')->getSecendlevel();
				$getCategoryIfExist3 = Mage::getResourceModel('catalog/category_collection')
				->addFieldToFilter('name',$childCategory)->addFieldToFilter('level', array('eq' => '3'))
				->addFieldToFilter('parent_id', array('eq' =>$getSession));
				$catData3 = $getCategoryIfExist3->getData();
					
				$subChildCategoryIfExist = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$subChildCategory)->addFieldToFilter('parent_id', array('eq' =>$catData3[0]['entity_id']))
				->addFieldToFilter('level', array('eq' => '4'));
				$subChildCategoryData = $subChildCategoryIfExist->getData();
			/*	echo '<pre>1';
				print_r($catData3);
				echo '<pre>';
				die;*/
				if($subChildCategoryData) 
				{
					
					// get all parent menu's ids
					$children = Mage::getModel('catalog/category')->load($catData3[0]['entity_id'])->getChildrenCategories();
					$arr = array();
					foreach ($children as $category) {
					$arr[] =  $category->getId();
					}	
					if(!in_array($subChildCategoryData[0]['entity_id'],$arr))	
					{		
						$category = Mage::getModel('catalog/category');
						$category->setName($subChildCategory);
						$category->setUrlKey($subChildCategory);
						$category->setMetaTitle($subChildCategory);
						$category->setIsActive(1);
						$category->setIncludeInMenu(0);
						$category->setDisplayMode('PRODUCTS');
						$category->setIsAnchor(1); //for active achor
						$category->setStoreId(Mage::app()->getStore()->getId());
						$subChildCategory = Mage::getModel('catalog/category')->load($catData3[0]['entity_id']);
						$category->setPath($subChildCategory->getPath());
						$category->save();
							
					} 
				}
				else{
						$getSession2 = Mage::getSingleton('core/session')->getSecendlevel();
						$getChildCateData = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name',$childCategory)->addFieldToFilter('level', array('eq' => '3'))
						->addFieldToFilter('parent_id', array('eq' =>$getSession2));
						$childCatData = array();
						$childCatData = $getChildCateData->getData();
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
						$subChildCategory = Mage::getModel('catalog/category')->load($catData3[0]['entity_id']);
						$category->setPath($subChildCategory->getPath());
						$category->save();
							
				
					}
					Mage::getSingleton('core/session')->unsSecendlevel();
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