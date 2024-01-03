<?php
namespace Levinci\FileManagement\Model\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
* Item required functionality model
*/
class Required extends AbstractSource implements SourceInterface, OptionSourceInterface
{
    /**#@+
    * Item Status values
    */
    const PRE_AUTHORIZATON = 0;

    const CLAIM = 1;

    /**#@-*/

    /**
    * Retrieve option array
    *
    * @return string[]
    */
    public static function getOptionArray()
    {
    return [self::PRE_AUTHORIZATON => __('Pre-Authorization'), self::CLAIM => __('Claim')];
    }

    /**
    * Retrieve option array with empty value
    *
    * @return string[]
    */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }
}