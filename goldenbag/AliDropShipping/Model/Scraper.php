<?php

/**
 ** 30/05/2021
 ** @author Kashif
 **/

namespace Dreamsites\AliDropShipping\Model;

use Goutte\Client;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Backend\Model\Session as ImageSession;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Psr\Log\LoggerInterface;

/**
 * Class Scraper
 * @package Dreamsites\AliRipper\Model
 **/
class Scraper
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ImageSession
     */
    public $imageSession;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Scraper constructor.
     * @param ImageSession $imageSession
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     */
    public function __construct(
        ImageSession $imageSession,
        Filesystem $filesystem,
        LoggerInterface $logger
    )
    {
        $this->client = new Client();
        $this->imageSession = $imageSession;
        $this->filesystem = $filesystem;
        $this->logger = $logger;
    }


    /**
     * Process the URL
     *
     * @param string $url
     * @return array
     */
    public function processUrl(string $url): array
    {
        $scrapedData = [];

        try {
            $crawler = $this->client->request('GET', $url);

            $response = $this->client->getInternalResponse();
            if ($response->getStatusCode() !== 200) {
                return ['response' => 500, 'error' => 'error retrieving URL'];
            }

            if ($crawler->filterXPath('//script')->count() > 0) {
                foreach ($crawler->filterXPath('//script') as $script) {
                    $scrapedData[] = $script->nodeValue;
                }
            }

        } catch (GuzzleException $e) {
            return ['response' => 500, 'error' => $e->getMessage()];
        }

        return $scrapedData;
    }

    /**
     * @return ImageSession
     */
    private function getImageSession()
    {
        return $this->imageSession;
    }

    /**
     * Parses the scripts in the source
     * and returns only the images
     *
     * @param string $url
     * @return array
     */
    public function getImages(string $url): array
    {
        $imageList = $this->processUrl($url);

        if (count($imageList) === 0 || (count($imageList) === 1 && $imageList['response'] === 500)) {
            return [500, 'No images were returned'];
        }

        $scriptNumberToUse = 16;

        for ($x = 14; $x <= 18; $x++) {
            if (array_key_exists($x, $imageList)) {
                if (strpos($imageList[$x], 'imagePathList')) {
                    $scriptNumberToUse = $x;
                    break;
                }
            }
        }

        $imgpath = strpos($imageList[$scriptNumberToUse], '"imagePathList"') + 17;
        $imagemodule = strpos($imageList[$scriptNumberToUse], ',"name":"ImageModule"') - 1;

        $imgArr = explode('"', substr($imageList[$scriptNumberToUse], $imgpath, $imagemodule - $imgpath));

        $images = [];

        foreach ($imgArr as $item) {
            if (strlen($item) > 2) {
                $images[] = $item;
            }
        }

        //Convert large images to webp and return them
        $webpImages = [];
        try {
            $tempDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
            $tempDir .= 'catalog/product/cache/';

            $tempImages = [];

            foreach ($images as $image) {
                $tmpFileName = $tempDir . 'dropshipping_image_' . uniqid(\Magento\Framework\Math\Random::getRandomNumber(), true) . time() . '.webp';
                $webpImages[] = $tmpFileName;
                if (strpos($image, '.png', -4) !== false) {
                    $imgPNG = imagecreatefrompng($image);
                    imagepalettetotruecolor($imgPNG);
                    imagealphablending($imgPNG, true);
                    imagesavealpha($imgPNG, true);
                    imagewebp(imagecreatefrompng($image), $tmpFileName, 60);
                    imagedestroy($imgPNG);

                    //Save to media folder
                    $tmpSaveDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                    $tmpSaveDir .= 'dropshipping/';
                    $tmpSaveDir->create();

                    $tmpSaveDir = $this->filesystem->getDirectoryWrite(
                        DirectoryList::MEDIA
                    );
                    $tmpSaveDir .= 'dropshipping/';

                    if (!file_exists($tmpSaveDir)) {
                        if (!mkdir($tmpSaveDir, 0755, true) && !is_dir($tmpSaveDir)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $tmpSaveDir));
                        }
                        chmod($tmpSaveDir, 0755);
                    }

                    $tempFileName = $tmpSaveDir . 'dropshipping_image_' . uniqid(\Magento\Framework\Math\Random::getRandomNumber(), true) . time() . '.png';
                    imagepng(imagecreatefrompng($image), $tempFileName, 100);

                    $tempImages[] = $tempFileName;
                } else {
                    $imgJpeg = imagecreatefromjpeg($image);
                    imagewebp($imgJpeg, $tmpFileName, 60);
                    imagedestroy($imgJpeg);

                    //Save to temp folder
                    $tmpSaveDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                    $tmpSaveDir .= 'dropshipping/';

                    if (!file_exists($tmpSaveDir)) {
                        if (!mkdir($tmpSaveDir, 0755, true) && !is_dir($tmpSaveDir)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $tmpSaveDir));
                        }
                        chmod($tmpSaveDir, 0755);
                    }

                    $tempFileName = $tmpSaveDir . 'dropshipping_image_' . uniqid(\Magento\Framework\Math\Random::getRandomNumber(), true) . time() . '.jpg';
                    imagejpeg(imagecreatefromjpeg($image), $tempFileName, 100);

                    $tempImages[] = $tempFileName;
                }
            }

            //Save full size images to magento session for the observer to pick up.
            $this->getImageSession()->setImages($tempImages);

        } catch (\Exception $e) {
            $this->logger->critical($e);
            return ['response' => $e->getCode(), 'error' => $e->getMessage()];
        }

        return $webpImages;
    }
}
