<?php
/**
 * Class Uploadimage
 * Author: Kashif Bhatti
 * 09/11/2025
 */

namespace DreamSites\CustomerPhotos\Controller\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;

class UploadImage extends Action
{
    protected $_fileUploaderFactory;
    protected $_dir;
    protected $_session;
    protected $_logger;

    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem\DirectoryList $dir,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Psr\Log\LoggerInterface $logger,
        Context $context
    ) {
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_dir = $dir;
        $this->_session = $session;
        $this->_logger = $logger;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $this->_logger->error('Image upload: ' . $_FILES['filename']['name']);

        if (($_FILES['filename']['name'] !== '') && isset($_FILES['filename']['name'])) {
            try {
                $directory = $this->_dir->getPath('media').'/photos/';
                $uploader = $this->_fileUploaderFactory->create(['fileId' => 'filename']);
                /** Allowed extension types */
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'webp']);
                /** rename file name if already exists */
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $uploader->setAllowCreateFolders(false);
                /** upload file in folder "photos" */
                $result = $uploader->save($directory);
                if ($result['file']) {
                    $this->_session->setData('uploaded_photo', $result['file']);
                    return $resultJson->setData([
                        'success' => true,
                        'filename' => $result['file'],
                        'message' => 'File uploaded successfully'
                    ]);
                }
            } catch (\Exception $e) {
                $this->_logger->error('Image upload failed: ' . $e->getMessage());
                return $resultJson->setData([
                    'success' => false,
                    'message' => 'Upload failed: ' . $e->getMessage()
                ]);
            }
        }

        return $resultJson->setData([
            'success' => false,
            'message' => 'Upload failed: '
        ]);
    }
}
