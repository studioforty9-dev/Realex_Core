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
class Realex_Core_Model_Remote_Response extends DOMDocument
{
    protected $_xpath = null;
    protected $_result = null;
    protected $_message = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function buildXml($xml){
        $this->loadXML($xml);
        $this->_xpath = new DOMXPath($this);
        $this->_message = $this->_getNodeValue('message');
        $this->_result = $this->_getNodeValue('result');
    }

    public function validate(){
        if($this->_result != '00'){
            switch(substr($this->_result, 0, 1)){
                case '1':
                    throw new Realex_Core_Exception_CardException($this->_message);
                case '3':
                    throw new Realex_Core_Exception_InternalRealexErrorException($this->_message);
                case '5':
                    throw new Realex_Core_Exception_InvalidDataException($this->_message);
            }
        }
    }

    protected function _getNodeValue($path, $singular = true){
        $nodes = $this->_xpath->query('//' . $path);
        $result = array();
        foreach($nodes as $node){
            array_push($result, $node->nodeValue);
            if($singular){
                return implode($result);
            }
        }

        return $result;
    }
}