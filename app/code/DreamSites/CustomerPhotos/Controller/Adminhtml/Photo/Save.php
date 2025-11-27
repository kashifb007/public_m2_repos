<?php
/**
 * Save photo form data
 */

namespace DreamSites\CustomerPhotos\Controller\Adminhtml\Photo;

use DreamSites\CustomerPhotos\Model\ImageFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param Context $context
     * @param ImageFactory $imageFactory
     * @param ProductRepositoryInterface $productRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \DreamSites\CustomerPhotos\Model\ImageFactory $imageFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->imageFactory = $imageFactory;
        $this->productRepository = $productRepository;
        parent::__construct($context);
        $this->_logger = $logger;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_CustomerPhotos::photo');
    }

    /**
     * Save Photo item.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('image_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        // Validate product_id exists
        if (!empty($data['product_id']) || is_int($data['product_id'])) {
            try {
                $this->productRepository->getById($data['product_id']);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(
                    __('The product with ID %1 does not exist. Please enter a valid Product ID.', $data['product_id'])
                );
                $this->_logger->warning('Invalid product_id in customer photo save: ' . $data['product_id']);

                // Redirect back to edit form with data
                if ($id !== null) {
                    return $resultRedirect->setPath('customerphotos/photo/edit', ['image_id' => $id]);
                }
            }
        } else {
            $this->messageManager->addErrorMessage(__('Product ID is required.'));
            if ($id !== null) {
                return $resultRedirect->setPath('customerphotos/photo/edit', ['image_id' => $id]);
            }
        }

        try {
            if ($id !== null) {
                $imageData = $this->imageFactory->create()->load((int)$id);
            } else {
                $imageData = $this->imageFactory->create();
            }

            $imageData->setData($data)->save();

            $this->messageManager->addSuccessMessage(__('Saved Customer Photo.'));
            $resultRedirect->setPath('customerphotos/photo');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->_logger->error('Save Customer Photo failed: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => __FILE__,
                'line' => __LINE__
            ]);

            $resultRedirect->setPath('customerphotos/photo/edit', ['image_id' => $id]);
        }
        return $resultRedirect;
    }
}
