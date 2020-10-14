<?php
/**
 * Delete controller
 */
namespace DreamSites\ReferaFriend\Controller\Adminhtml\Referlist;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites::referlist');
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('image_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create('DreamSites\ReferaFriend\Model\Refer');
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
