<?php
/**
 * Page Model
 */
namespace DreamSites\HomeCarousel\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\StoreManagerInterface;

class Image extends AbstractModel
{
    const POSITION_LEFT = 'justify-start';
    const POSITION_CENTRE = 'justify-center';
    const POSITION_RIGHT = 'justify-end';

    const POSITION_TOP = 'items-start';
    const POSITION_MIDDLE = 'items-center';
    const POSITION_BOTTOM = 'items-end';

    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\HomeCarousel\Model\ResourceModel\Image');
        parent::_construct();
    }

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function getMediaPath()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'carousel/' . $this->getImageFilename();
    }

    /**
     * @return array
     */
    public function getAvailablePositions()
    {
        return [
            self::POSITION_LEFT => __('Left'),
            self::POSITION_CENTRE => __('Centre'),
            self::POSITION_RIGHT => __('Right')
        ];
    }

    /**
     * @return array
     */
    public function getAvailableVerticalPositions()
    {
        return [
            self::POSITION_TOP => __('Top'),
            self::POSITION_MIDDLE => __('Middle'),
            self::POSITION_BOTTOM => __('Bottom')
        ];
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->getData('position');
    }

    /**
     * @param $position
     * @return mixed
     */
    public function setPosition($position)
    {
        return $this->setData('position', $position);
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->getData('sort_order');
    }

    /**
     * @param $sortOrder
     * @return mixed
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData('sort_order', $sortOrder);
    }

    /**
     * @return mixed
     */
    public function getImageId()
    {
        return $this->getData('image_id');
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * @param $title
     * @return Image
     */
    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->getData('is_active');
    }

    /**
     * @param $isActive
     * @return Image
     */
    public function setIsActive($isActive)
    {
        return $this->setData('is_active', $isActive);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    /**
     * @return mixed
     */
    public function getButtonColour()
    {
        return $this->getData('button_colour');
    }

    /**
     * @param $buttonColour
     * @return Image
     */
    public function setButtonColour($buttonColour)
    {
        return $this->setData('button_colour', $buttonColour);
    }

    /**
     * @return mixed
     */
    public function getButtonTextColour()
    {
        return $this->getData('button_text_colour');
    }

    /**
     * @param $buttonTextColour
     * @return Image
     */
    public function setButtonTextColour($buttonTextColour)
    {
        return $this->setData('button_text_colour', $buttonTextColour);
    }

    /**
     * @return mixed
     */
    public function getTitleColour()
    {
        return $this->getData('title_colour');
    }

    /**
     * @param $titleColour
     * @return Image
     */
    public function setTitleColour($titleColour)
    {
        return $this->setData('title_colour', $titleColour);
    }

    /**
     * @return mixed
     */
    public function getHeadingColour()
    {
        return $this->getData('heading_colour');
    }

    /**
     * @param $headingColour
     * @return Image
     */
    public function setHeadingColour($headingColour)
    {
        return $this->setData('heading_colour', $headingColour);
    }

    /**
     * @return mixed
     */
    public function getImageFilename()
    {
        return $this->getData('image_filename');
    }

    /**
     * @param $imageFilename
     * @return Image
     */
    public function setImageFilename($imageFilename)
    {
        return $this->setData('image_filename', $imageFilename);
    }

    /**
     * @return mixed
     */
    public function getImageAlt()
    {
        return $this->getData('image_alt');
    }

    /**
     * @param $imageAlt
     * @return Image
     */
    public function setImageAlt($imageAlt)
    {
        return $this->setData('image_alt', $imageAlt);
    }

    /**
     * @return mixed
     */
    public function getHeading()
    {
        return $this->getData('heading');
    }

    /**
     * @param $heading
     * @return Image
     */
    public function setHeading($heading)
    {
        return $this->setData('heading', $heading);
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->getData('url');
    }

    /**
     * @param $url
     * @return Image
     */
    public function setUrl($url)
    {
        return $this->setData('url', $url);
    }

    /**
     * @return mixed
     */
    public function getButtonText()
    {
        return $this->getData('button_text');
    }

    /**
     * @param $buttonText
     * @return Image
     */
    public function setButtonText($buttonText)
    {
        return $this->setData('button_text', $buttonText);
    }

    /**
     * @return mixed
     */
    public function getCarouselName()
    {
        return $this->getData('carousel_name');
    }

    /**
     * @param $carouselName
     * @return Image
     */
    public function setCarouselName($carouselName)
    {
        return $this->setData('carousel_name', $carouselName);
    }

    /**
     * @return mixed
     */
    public function getVerticalPosition()
    {
        return $this->getData('vertical_position');
    }

    /**
     * @param $verticalPosition
     * @return Image
     */
    public function setVerticalPosition($verticalPosition)
    {
        return $this->setData('vertical_position', $verticalPosition);
    }
}
