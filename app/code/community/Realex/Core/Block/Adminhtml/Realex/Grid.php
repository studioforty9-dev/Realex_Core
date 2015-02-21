<?php
/**
 * Realex_Core extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Realex
 * @package    Realex_Core
 * @copyright  Copyright (c) 2015 StudioForty9
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Realex
 * @package    Realex_Core
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Realex_Core_Block_Adminhtml_Realex_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('realexGrid');
        //$this->setDefaultSort('order_date');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('realex_core/transaction')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

//    $this->addColumn('realex_id', array(
//          'header'    => Mage::helper('realex_core')->__('ID'),
//          'align'     =>'right',
//          'width'     => '50px',
//          'index'     => 'realex_id',
//     ));

        $this->addColumn('order_id',
            array(
                'header' => Mage::helper('realex_core')->__('Order ID'),
                'index' => 'order_increment_id',
            ));

        $this->addColumn('timestamp',
            array(
                'header' => Mage::helper('realex_core')->__('Timestamp'),
                'type' => 'datetime',
                'index' => 'timestamp',
            ));

//      $this->addColumn('merchantid', array(
//          'header'    => Mage::helper('realex_core')->__('Merchant ID'),
//          'index'     => 'merchantid',
//     ));
//
//      $this->addColumn('account', array(
//          'header'    => Mage::helper('realex_core')->__('Account'),
//          'index'     => 'account',
//     ));

        $this->addColumn('authcode',
            array(
                'header' => Mage::helper('realex_core')->__('Authcode'),
                'index' => 'authcode',
            ));

        $this->addColumn('result',
            array(
                'header' => Mage::helper('realex_core')->__('Result'),
                'index' => 'result',
                'width' => '50px',

            ));

        $this->addColumn('message',
            array(
                'header' => Mage::helper('realex_core')->__('Message'),
                'index' => 'message',
            ));

        $this->addColumn('pasref',
            array(
                'header' => Mage::helper('realex_core')->__('PasRef'),
                'index' => 'pasref',
            ));

        $this->addColumn('cvnresult',
            array(
                'header' => Mage::helper('realex_core')->__('CVN Result'),
                'index' => 'cvnresult',
                'width' => '50px',
            ));

        $this->addColumn('batchid',
            array(
                'header' => Mage::helper('realex_core')->__('Batch ID'),
                'index' => 'batchid',
            ));

        $this->addColumn('card_issuer_bank',
            array(
                'header' => Mage::helper('realex_core')->__('Bank'),
                'index' => 'card_issuer_bank',
            ));

        $this->addColumn('card_issuer_country',
            array(
                'header' => Mage::helper('realex_core')->__('Country'),
                'index' => 'card_issuer_country',
            ));

        $this->addColumn('tss_result',
            array(
                'header' => Mage::helper('realex_core')->__('TSS Result'),
                'index' => 'tss_result',
            ));

        $this->addColumn('avspostcoderesponse',
            array(
                'header' => Mage::helper('realex_core')->__('AVS Postcode'),
                'index' => 'avspostcoderesponse',
                'width' => '50px',
            ));

        $this->addColumn('avsaddressresponse',
            array(
                'header' => Mage::helper('realex_core')->__('AVS Address'),
                'index' => 'avsaddressresponse',
                'width' => '50px',
            ));

        $this->addColumn('timetaken',
            array(
                'header' => Mage::helper('realex_core')->__('Time Taken'),
                'index' => 'timetaken',
                'width' => '50px',
            ));

        $this->addColumn('authtimetaken',
            array(
                'header' => Mage::helper('realex_core')->__('Auth Time Taken'),
                'index' => 'authtimetaken',
                'width' => '50px',
            ));

        $this->addExportType('*/*/exportCsv', Mage::helper('realex_core')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('realex_core')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        return $this;
    }

    public function getRowUrl($row)
    {
        return false;
    }

}