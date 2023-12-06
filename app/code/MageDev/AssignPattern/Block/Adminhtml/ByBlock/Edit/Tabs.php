<?php
namespace MageDev\AssignPattern\Block\Adminhtml\ByBlock\Edit;

/**
 * @method Tabs setTitle(string $title)
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('assign_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Assign Information'));
    }
}
