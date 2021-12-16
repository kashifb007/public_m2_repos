<?php
/**
 * Delete controller
 *
 * @package DreamSites_ImageUpload
 * @author  Kashif Bhatti <kash@dreamsites.co.uk>
 * @created 01-08-2021
 * @copyright Copyright (c) 2021 Dream Sites, https://www.dreamsites.uk
 */
namespace DreamSites\ImageUpload\Controller\Adminhtml\Imagelist;

use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package DreamSites\ImageUpload\Controller\Adminhtml\Imagelist
 */
class Delete extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_ImageUpload::imagelist');
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('image_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create('DreamSites\ImageUpload\Model\Image');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The item has been deleted.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['image_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a listing to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
