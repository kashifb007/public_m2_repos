<?php
/**
 * Frontend Form Save Controller
 */
namespace DreamSites\CustomerPhotos\Controller\Index;

use DreamSites\CustomerPhotos\Model\ImageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    /**
     * @var ImageFactory
     */
    protected $imageFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    protected $_session;

    /**
     * @param Context $context
     * @param ImageFactory $imageFactory
     * @param LoggerInterface $logger
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context $context,
        ImageFactory $imageFactory,
        LoggerInterface $logger,
        RedirectFactory $resultRedirectFactory,
        \Magento\Framework\Session\SessionManagerInterface $session,
    ) {
        $this->imageFactory = $imageFactory;
        $this->logger = $logger;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->_session = $session;
        parent::__construct($context);
    }

    /**
     * Save customer photo submission
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data received.'));
            return $resultRedirect->setPath('*/*/');
        }

        // Validate required fields
        if (empty($data['customer_name'])) {
            $this->messageManager->addErrorMessage(__('Customer Name is required.'));
            return $resultRedirect->setPath('*/*/');
        }

        //save uploaded filename from session if available
        $data['image_filename'] = '';
        $savedFilename = $this->_session->getData('uploaded_photo');
        if ($savedFilename !== null) {
            $data['image_filename'] = $savedFilename;
        }

        if (empty($data['image_filename'])) {
            $this->messageManager->addErrorMessage(__('Image Filename is required.'));
            return $resultRedirect->setPath('*/*/');
        }

        if (empty($data['product_id'])) {
            $this->messageManager->addErrorMessage(__('Product ID is required.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $model = $this->imageFactory->create();
            $model->setData($data);
            $model->save();

            $this->messageManager->addSuccessMessage(__('Thank you for posting your photo! It will be reviewed by our team.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while saving your submission. Please try again.'));
            $this->logger->error('Customer Photo Save Error: ' . $e->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
