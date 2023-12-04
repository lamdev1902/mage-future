<?php
namespace MageDev\ImagePattern\Ui\Component\Listing\Column\ByUiComponent;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use MageDev\ImagePattern\Helper\Data;

class ImageListing extends Column
{
    const ALT_FIELD = 'title';

    /**
     * @var Data $helper
     */
    protected $helper;

    /**
     * @var UrlInterface $urlBuilder
     */
    protected $urlBuilder;
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Data $helper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Data $helper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items'])) {
            $action = 'imgpattern/byuicomponent/edit';
            $fieldName = $this->getData('name');

            foreach($dataSource['data']['items'] as & $item) {
                $url = '';
                if($item[$fieldName] != '') {
                    $url = $this->helper->getMediaUrl().$item[$fieldName];
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = '';
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    $action,
                    ['entity_id' => $item['entity_id']]
                );
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}