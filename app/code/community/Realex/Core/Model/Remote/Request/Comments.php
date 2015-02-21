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
class Realex_Core_Model_Remote_Request_Comments extends Realex_Core_Model_Remote_Request_Element
{
    protected $_comments = array();

    public function __construct(){
        parent::__construct('comments', null);

        for ($i = 1; $i < 3; $i++) {
            $comment = Mage::getModel('realex_core/remote_request_comments_comment');
            $comment->setId($i);
            array_push($this->_comments, $comment);
        }
    }

    public function buildXml(){
        foreach ($this->_comments as $comment) {
            $this->appendChild($comment);
            $comment->buildXml();
        }
    }
}