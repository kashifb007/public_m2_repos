<?php
/**
 * Delete Photo Controller
 */
namespace DreamSites\CustomerPhotos\Controller\Adminhtml\Photo;

use Magento\Backend\App\Action;

class Delete extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_CustomerPhotos::photo');
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('image_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->_objectManager->create('DreamSites\CustomerPhotos\Model\Image');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The photo has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['image_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a photo to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
