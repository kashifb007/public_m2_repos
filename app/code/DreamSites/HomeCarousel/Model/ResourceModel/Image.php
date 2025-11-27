<?php
/**
 * Page MySQL Resource
 */
namespace DreamSites\HomeCarousel\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Image extends AbstractDb
{

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_date = $date;
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dreamsites_carousel', 'image_id');
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {

        if ($object->isObjectNew() && !$object->hasData('created_at')) {
            $object->setData('created_at', $this->_date->gmtDate());
        }

        $object->setData('updated_at', $this->_date->gmtDate());

        return parent::_beforeSave($object);
    }

    public function getTitle(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getTitle();
    }

    public function getImageId(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getImageId();
    }

    public function getHeading(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getHeading();
    }

    public function getImageFilename(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getImageFilename();
    }

    public function getImageAlt(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getImageAlt();
    }

    public function getUrl(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getUrl();
    }

    public function getIsActive(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getIsActive();
    }

    public function getButtonText(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getButtonText();
    }

    public function getCarouselName(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getCarouselName();
    }

    public function getPosition(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getPosition();
    }

    public function getSortOrder(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getSortOrder();
    }

    public function getButtonColour(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getButtonColour();
    }

    public function getHeadingColour(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getHeadingColour();
    }

    public function getTitleColour(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getTitleColour();
    }

    public function getButtonTextColour(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getButtonTextColour();
    }

    public function getVerticalPosition(\DreamSites\HomeCarousel\Model\Image $image)
    {
        return $image->getVerticalPosition();
    }
}
