<?php
/**
 * InlineEdit.php
 * Author: Kashif Bhatti
 * 16/09/2025
 */

namespace DreamSites\Blog\Controller\Adminhtml\CommentList;

use Magento\Backend\App\Action;

class InlineEdit extends Action
{
    protected $jsonFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context              $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    )
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $entityId) {
                    $model = $this->_objectManager->create('DreamSites\Blog\Model\Comment')->load($entityId);
                    try {
                        $itemData = $postItems[$entityId];
                        // Prevent overwriting created_at during inline edit
                        unset($itemData['created_at']);
                        $model->setData(array_merge($model->getData(), $itemData));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Error:]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_Blog::pagelist');
    }

}
