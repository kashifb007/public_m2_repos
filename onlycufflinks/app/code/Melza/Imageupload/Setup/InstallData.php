<?php
namespace Melza\Imageupload\Setup;
use Melza\Imageupload\Model\Image;
use Melza\Imageupload\Model\ImageFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class InstallData implements InstallDataInterface
{
/**
* Image factory
*
* @var ImageFactory
*/
private $imageFactory;

/**
* Init
*
* @param ImageFactory $imageFactory
*/
public function __construct(ImageFactory $imageFactory)
{
$this->imageFactory = $imageFactory;
}
/**
* {@inheritdoc}

@SuppressWarnings(PHPMD.ExcessiveMethodLength)
*/
public function install(ModuleDataSetupInterface $setup,
ModuleContextInterface $context)
{
	$imageData = [
	'title' => 'Desktop Static 1-1',
	'image_identifier' => 'desktop_static_block_1_1',
	'is_active' => 1,
	];
/**
* Insert image data
*/
$this->createImage()->setData($imageData)->save();
}
/**
* Create image
*
* @return Image
*/
	public function createImage()
	{
		return $this->imageFactory->create();
	}
}