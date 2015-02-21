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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableName = 'realex_core/transaction';
if ($installer->getConnection()->isTableExists($tableName) != true) {

    /* @var $table Varien_Db_Ddl_Table */
    $table = $this->getConnection()->newTable($this->getTable($tableName));

    $table->addColumn('realex_transaction_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        11,
        array('identity' => true, 'primary' => true)
    );

    $table->addColumn('order_increment_id',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        50,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('timestamp',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array('nullable' => true, 'default' => NULL)
    );

    $table->addColumn('merchantid',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('account',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('authcode',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false)
    );

    $table->addColumn('result',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false)
    );

    $table->addColumn('message',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('pasref',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('cvnresult',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('batchid',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('card_issuer_bank',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('card_issuer_country',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('tss_result',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('avspostcoderesponse',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('avsaddressresponse',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('timetaken',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addColumn('authtimetaken',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        array('nullable' => false, 'default' => '')
    );

    $table->addForeignKey($this->getFkName(
        $tableName,
        'order_increment_id',
        'sales/order',
        'increment_id'),
        'order_increment_id',
        $this->getTable('sales/order'),
        'increment_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );

    $this->getConnection()->createTable($table);
}

$installer->endSetup();