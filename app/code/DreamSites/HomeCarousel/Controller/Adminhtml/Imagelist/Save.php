<?php
/**
 * Save page form data
 */

namespace DreamSites\HomeCarousel\Controller\Adminhtml\Imagelist;

use DreamSites\HomeCarousel\Model\ImageFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Registry;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    /**
     * Image factory
     *
     * @var \DreamSites\HomeCarousel\Model\ImageFactory
     */
    private $imageFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_logger;
    protected $_dir;
    protected $_fileUploaderFactory;

    /**
     * Initialize Group Controller
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ImageFactory $imageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     * @param LoggerInterface $logger
     * @param UploaderFactory $fileUploaderFactory
     * @param DirectoryList $dir
     */
    public function __construct(
        \Magento\Backend\App\Action\Context               $context,
        \Magento\Framework\Registry                       $coreRegistry,
        \DreamSites\HomeCarousel\Model\ImageFactory       $imageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory        $resultPageFactory,
        \Psr\Log\LoggerInterface                          $logger,
        \Magento\MediaStorage\Model\File\UploaderFactory  $fileUploaderFactory,
        \Magento\Framework\Filesystem\DirectoryList       $dir,
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->imageFactory = $imageFactory;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_logger = $logger;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_dir = $dir;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_HomeCarousel::imagelist');
    }

    /**
     * Save PageList item.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('image_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            if ($id !== null) {
                $pageData = $this->imageFactory->create()->load((int)$id);
            } else {
                $pageData = $this->imageFactory->create();
            }
            $data = $this->getRequest()->getParams();

            /**
             * begin upload image
             */
            if (($_FILES['image_filename']['name'] !== '') && isset($_FILES['image_filename']['name'])) {
                try {
                    $directory = $this->_dir->getPath('media') . '/carousel/';
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => 'image_filename']);
                    /** Allowed extension types */
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    /** rename file name if already exists */
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $uploader->setAllowCreateFolders(false);
                    /** upload file in folder "home" */
                    $result = $uploader->save($directory);
                } catch (\Exception $e) {
                    $this->_logger->error('Image upload failed: ' . $e->getMessage());
                }

                if ($result['file']) {
                    $data['image_filename'] = $result['file'];
                }
            }
            /**
             * end upload image
             */

            if (empty($data['heading_colour'])) {
                $data['heading_colour'] = '#1b1c1d';
            }

            if (empty($data['title_colour'])) {
                $data['title_colour'] = '#585858';
            }

            if (empty($data['button_colour'])) {
                $data['button_colour'] = '#cb2879';
            }

            if (empty($data['button_text_colour'])) {
                $data['button_text_colour'] = '#ffffff';
            }

            $pageData->setData($data)->save();

            $this->messageManager->addSuccess(__('Saved Carousel Item.'));
            $resultRedirect->setPath('homecarousel/imagelist');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_getSession()->setPageData($data);
            // Log the error using Magento's PSR-3 logger
            $this->_logger->error('Save Carousel Item failed: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => __FILE__,
                'line' => __LINE__
            ]);

            $resultRedirect->setPath('homecarousel/imagelist/edit', ['image_id' => $id]);
        }
        return $resultRedirect;
    }
}
