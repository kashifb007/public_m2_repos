<?php
/**
 * Comment Content Column - Truncates comment to 100 characters
 */
namespace DreamSites\Blog\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class CommentContent extends Column
{
    const MAX_LENGTH = 100;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[$name])) {
                    $content = $item[$name];
                    // Strip HTML tags first
                    $content = strip_tags($content);
                    // Truncate to 100 characters
                    if (strlen($content) > self::MAX_LENGTH) {
                        $content = substr($content, 0, self::MAX_LENGTH) . '...';
                    }
                    $item[$name] = $content;
                }
            }
        }

        return $dataSource;
    }
}
