<?php

class Magebuzz_Banners_Adminhtml_BannersController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('banners/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Banners'), Mage::helper('adminhtml')->__('Manage Bannersr'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}



	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('banners/banners')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('banners_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('banners/items');

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
			
			$this->_addContent($this->getLayout()->createBlock('banners/adminhtml_banners_edit'))
				->_addLeft($this->getLayout()->createBlock('banners/adminhtml_banners_edit_tabs'));
			
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banners')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('banners/adminhtml_banners_grid')->toHtml());
    }

    public function saveAction() {
        $model = Mage::getModel('banners/banners');
        if ($data = $this->getRequest()->getPost()) {

            if(isset($_FILES['bannerimage']['name']) && $_FILES['bannerimage']['name'] != '') {
                $imgName = $_FILES['bannerimage']['name'];
                $imgName = str_replace(' ', '_',$imgName);

                $path = Mage::getBaseDir('media')."/Banners". DS ."images". DS ;
                $uploader = new Varien_File_Uploader('bannerimage');
                $uploader->setAllowedExtensions(array('jpg','JPG','jpeg','gif','GIF','png','PNG'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);

                $destFile = $path.$imgName;
                $imgName  = $model->getNewFileName($destFile);
                $uploader->save($path,$imgName);
                // We set media as the upload dir
                $uploader->save($path, $_FILES['bannerimage']['name'] );
                //this way the name is saved in DB
                $data['bannerimage'] = $imgName;

                //Save Image Tag in DB for GRID View
                $imgPath = Mage::getBaseUrl('media')."Banners/images/".$imgName;
                $data['filethumbgrid'] = '<img src="'.$imgPath.'" border="0" width="80" height="80" />';
            }

            $model = Mage::getModel('banners/banners');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));
//
//            var_dump($model->getData());
//            die('ssssssssssss');
            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();

                //Mage::helper('banners')->generateXML();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banners')->__('Banner was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banners')->__('Unable to find Banner to save'));
        $this->_redirect('*/*/');
    }
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('banners/banners');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $bannersIds = $this->getRequest()->getParam('banners');
        if(!is_array($bannersIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannersIds as $bannersId) {
                    $banners = Mage::getModel('banners/banners')->load($bannersId);
                    $banners->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($bannersIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $bannersIds = $this->getRequest()->getParam('banners');
        if(!is_array($bannersIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($bannersIds as $bannersId) {
                    $banners = Mage::getSingleton('banners/banners')
                        ->load($bannersId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($bannersIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'banners.csv';
        $content    = $this->getLayout()->createBlock('banners/adminhtml_banners_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'banners.xml';
        $content    = $this->getLayout()->createBlock('banners/adminhtml_banners_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}