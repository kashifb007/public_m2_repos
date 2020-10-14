<?php
/**
 *
 * Image.php
 *
 * 18/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model\Article;

use Magento\Framework\UrlInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class Image
{
    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'cms_page';
    /**
     * url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $fileSystem;

    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $fileSystem
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
    }

    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir . '/image';
    }

    /**
     * get base image dir
     *
     * @return string
     */
    public function getBaseDir()
    {
        return $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath($this->subDir . '/image');
    }
}