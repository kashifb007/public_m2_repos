<?php
/**
 *
 * DataProvider.php
 *
 * 18/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model\Article;

use Magento\Framework\App\Request\DataPersistorInterface;
use Ukpos\KnowledgeHub\Model\ResourceModel\Article\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{

    protected $collection;

    protected $dataPersistor;

    public $storeManager;

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $articleCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $articleCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $baseurl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $temp = $item->getData();
            if ($temp['image']):
                $img = [];
                $img[0]['image'] = $temp['image'];
                $img[0]['url'] = $baseurl . 'test/' . $temp['image'];
                $temp['logo'] = $img;
            endif;

            $data = $this->dataPersistor->get('article');
            if (!empty($data)) {
                $item = $this->collection->getNewEmptyItem();
                $item->setData($data);
                $this->loadedData[$item->getLabelId()] = $item->getData();
                $this->dataPersistor->clear('article');
            } else {
                if ($items):
                    if ($item->getData('image') != null) {

                        $t2[$item->getId()] = $temp;

                        return $t2;
                    } else {
                        return $this->loadedData;
                    }
                endif;
            }
        }
        return $this->loadedData;
    }

}