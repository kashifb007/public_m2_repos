<?php
/**
 * Form container for Comment edit/new
 */
namespace DreamSites\Blog\Block\Adminhtml\Comment;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Current comment record id
     *
     * @var bool|int
     */
    protected $commentId = false;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Remove Delete button if record can't be deleted.
     * Remove Save and Continue button since we can't create new comments.
     * Remove Reset button - not needed for comments.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'comment_id';
        $this->_controller = 'adminhtml_comment';
        $this->_blockGroup = 'DreamSites_Blog';

        parent::_construct();

        $commentId = $this->getCommentId();
        if (!$commentId) {
            $this->buttonList->remove('delete');
            $this->buttonList->remove('save');
            $this->buttonList->remove('reset');
        }

        // Remove 'Save and Continue' button - not needed for comments
        $this->buttonList->remove('save_and_continue');

        // Remove 'Reset' button - not needed for comments
        $this->buttonList->remove('reset');
    }

    /**
     * Retrieve the header text for editing an existing record.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $commentId = $this->getCommentId();
        if ($commentId) {
            return __('Edit Comment');
        }
        return __('Comment');
    }

    public function getCommentId()
    {
        if (!$this->commentId) {
            $this->commentId=$this->coreRegistry->registry('current_comment_id');
        }
        return $this->commentId;
    }
}
