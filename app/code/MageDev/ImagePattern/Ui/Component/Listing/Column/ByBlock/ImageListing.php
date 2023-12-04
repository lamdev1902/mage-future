<?php
namespace MageDev\ImagePattern\Ui\Component\Listing\Column\ByBlock;

use Exception;
use Magento\Framework\DataObject;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use MageDev\ImagePattern\Model\Config\Source\Image;

/**
 * Class Content
 * @package MageDev\ImagePattern\Ui\Component\Listing\Column
 */
class ImageListing extends Column
{

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Image
     */
    protected $imageModel;

    /**
     * Content constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Image $imageModel
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Image $imageModel,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->imageModel = $imageModel;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     * @throws Exception
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->imageModel->getBaseUrl();
            foreach ($dataSource['data']['items'] as & $item) {
                $imgData = new DataObject($item);
                if ($item['image']) {
                    $item[$fieldName . '_src'] = $path . $item['image'];
                }

                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'imgpaterrn/byblock/edit',
                    ['entity_id' => $imgData->getEntityId(), 'store' => $this->context->getRequestParam('store')]
                );
            }
        }

        return $dataSource;
    }
}
