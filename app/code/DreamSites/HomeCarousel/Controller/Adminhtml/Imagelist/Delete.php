<?php
/**
 * Delete controller
 */
namespace DreamSites\HomeCarousel\Controller\Adminhtml\Imagelist;

use Magento\Backend\App\Action;

class Delete extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_HomeCarousel::imagelist');
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('image_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('DreamSites\HomeCarousel\Model\Image');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The item has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['image_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a listing to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
