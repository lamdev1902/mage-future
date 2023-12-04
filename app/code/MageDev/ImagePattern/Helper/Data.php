<?php
namespace MageDev\ImagePattern\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;

class Data
{
    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @var ResourceConnection $resourceConnection
     */
    protected $resourceConnection;

    /**
     * @var File $file
     */
    protected $file;

    /**
     * @var Filesystem $fileSystem
     */
    protected $fileSystem;

    public function __construct(
        File $file,
        Filesystem $fileSystem,
        ResourceConnection $resourceConnection,
        StoreManagerInterface $storeManager
    )
    {
        $this->file = $file;
        $this->fileSystem = $fileSystem;
        $this->resourceConnection = $resourceConnection;
        $this->storeManager = $storeManager;
    }


    public function filterImageData($currentImgName, array $data, $fieldName)
    {

        $mediaRootDir = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $folder = 'magedev/tmp/img/';

        if(!empty($data[$fieldName])){
            $img = str_contains($data[$fieldName][0]['name'],$folder) ? $data[$fieldName][0]['name'] : $folder.$data[$fieldName][0]['name'];
            if($currentImgName && $currentImgName !== $img)
            {
                if ($this->file->isExists($mediaRootDir . $currentImgName)) {
                    $this->file->deleteFile($mediaRootDir . $currentImgName);
                }
            }
            $data[$fieldName] = $img;
        }else{
            $data[$fieldName] = '';
        }
        return $data;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
                        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl;
    }
}
