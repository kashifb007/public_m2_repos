<?php
/**
 * Controller to handle comment submission
 *
 * @package DreamSites_Blog
 */
namespace DreamSites\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\Exception\LocalizedException;
use DreamSites\Blog\Model\CommentFactory;
use DreamSites\Blog\Model\PageFactory;
use Psr\Log\LoggerInterface;

class Post extends Action implements HttpPostActionInterface
{
    /**
     * @var FormKeyValidator
     */
    protected $formKeyValidator;

    /**
     * @var CommentFactory
     */
    protected $commentFactory;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Context $context
     * @param FormKeyValidator $formKeyValidator
     * @param CommentFactory $commentFactory
     * @param PageFactory $pageFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        FormKeyValidator $formKeyValidator,
        CommentFactory $commentFactory,
        PageFactory $pageFactory,
        LoggerInterface $logger
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->commentFactory = $commentFactory;
        $this->pageFactory = $pageFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Handle comment submission
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        // Validate CSRF token
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage(__('Invalid form key. Please try again.'));
            return $resultRedirect->setRefererUrl();
        }

        // Check if POST request
        if (!$this->getRequest()->isPost()) {
            return $resultRedirect->setRefererUrl();
        }

        try {
            // Get and validate POST data
            $data = $this->getRequest()->getPostValue();

            // Validate required fields
            $this->validateCommentData($data);

            $pageId = (int)$data['page_id'];

            // Check if page exists and has comments enabled
            $page = $this->pageFactory->create()->load($pageId);
            if (!$page->getPageId() || !$page->getHasComments()) {
                throw new LocalizedException(__('Comments are not enabled for this page.'));
            }

            // Create and save comment
            $comment = $this->commentFactory->create();
            $comment->setData([
                'page_id' => $pageId,
                'author_name' => $this->sanitizeInput($data['author_name']),
                'author_email' => $this->sanitizeInput($data['author_email']),
                'content' => $this->sanitizeInput($data['content']),
            ]);

            $comment->save();

            $this->messageManager->addSuccessMessage(
                __('Your comment has been submitted and is awaiting approval.')
            );

        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(
                __('An error occurred while submitting your comment. Please try again.')
            );
        }

        return $resultRedirect->setRefererUrl();
    }

    /**
     * Validate comment data
     *
     * @param array $data
     * @throws LocalizedException
     * @return void
     */
    protected function validateCommentData($data)
    {
        if (empty($data['page_id'])) {
            throw new LocalizedException(__('Page ID is required.'));
        }

        if (empty($data['author_name']) || trim($data['author_name']) === '') {
            throw new LocalizedException(__('Author Name is required.'));
        }

        if (empty($data['author_email']) || trim($data['author_email']) === '') {
            throw new LocalizedException(__('Email is required.'));
        }

        if (!filter_var($data['author_email'], FILTER_VALIDATE_EMAIL)) {
            throw new LocalizedException(__('Please enter a valid email address.'));
        }

        if (empty($data['content']) || trim($data['content']) === '') {
            throw new LocalizedException(__('Content is required.'));
        }

        // Check length limits
        if (strlen($data['author_name']) > 255) {
            throw new LocalizedException(__('Invalid Author Name. Maximum 255 characters.'));
        }

        if (strlen($data['author_email']) > 255) {
            throw new LocalizedException(__('Invalid Email. Maximum 255 characters.'));
        }

        if (strlen($data['content']) > 5000) {
            throw new LocalizedException(__('Invalid content. Maximum 5000 characters.'));
        }
    }

    /**
     * Sanitize input to prevent XSS attacks
     *
     * @param string $input
     * @return string
     */
    protected function sanitizeInput($input)
    {
        // Strip tags and trim whitespace
        return strip_tags(trim($input));
    }
}
