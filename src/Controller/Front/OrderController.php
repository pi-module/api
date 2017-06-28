<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Apis\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
class OrderController extends ActionController
{
    public function orderListAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => '',
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        $uid = $this->params('uid');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Load language
                    Pi::service('i18n')->load(array('module/order', 'default'));
                    // Get list
                    $orders = Pi::api('order', 'order')->getOrderFromUser($uid, true);
                    $list = array();
                    foreach ($orders as $order) {
                        $products = Pi::api('order', 'order')->listProduct($order['id'], $order['module_name']);
                        $productsList = array();
                        $list[$order['id']] = $order;
                        foreach ($products as $product) {
                            $productsList[] = $product['details']['title'];
                        }
                        $list[$order['id']]['products'] = implode(' , ',$productsList);
                    }
                    $result['list'] = array_values($list);

                    $result['status'] = 1;
                    $result['message'] = 'Its work !';
                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function orderSingleAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => '',
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        $uid = $this->params('uid');
        $id = $this->params('id');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {



                    // Load language
                    Pi::service('i18n')->load(array('module/order', 'default'));
                    // Get list
                    $order =  Pi::api('order', 'order')->getOrder($id);
                    if ($order['uid'] == $uid) {
                        $order = array($order);
                        return $order;
                    }


                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function invoiceListAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => '',
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        $uid = $this->params('uid');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(array('module/order', 'default'));
                    // Get list
                    $invoiceList = Pi::api('invoice', 'order')->getInvoiceFromUser($uid, true);
                    $list = array();
                    foreach ($invoiceList as $invoiceSingle) {
                        $order = Pi::api('order', 'order')->getOrder($invoiceSingle['order']);
                        $products = Pi::api('order', 'order')->listProduct($order['id'], $order['module_name']);
                        $productsList = array();
                        foreach ($products as $product) {
                            $productsList[] = $product['details']['title'];
                        }

                        $list[$invoiceSingle['id']] = $invoiceSingle;
                        //$list[$invoiceSingle['id']]['orderInfo'] = $order;
                        $list[$invoiceSingle['id']]['products'] = implode(' , ',$productsList);
                    }
                    $result['list'] = array_values($list);



                    $result['status'] = 1;
                    $result['message'] = 'Its work !';
                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function invoiceSingleAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => '',
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        $uid = $this->params('uid');
        $id = $this->params('id');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {




                    // Load language
                    Pi::service('i18n')->load(array('module/order', 'default'));
                    // Get list
                    $invoice = Pi::api('invoice', 'order')->getInvoice($id);
                    if ($invoice['uid'] == $uid) {
                        $invoice = array($invoice);
                        return $invoice;
                    }




                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function preOrderListAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => '',
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        $uid = $this->params('uid');
        // Check module
        if (Pi::service('module')->isActive('order') && Pi::service('module')->isActive('preorder')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {




                    $result['list'] = array();
                    $where = array('uid' => $uid);
                    $order = array('time_create DESC', 'id DESC');
                    $select = Pi::model('order', 'preorder')->select()->where($where)->order($order);
                    $rowset = Pi::model('order', 'preorder')->selectWith($select);
                    // Make list
                    foreach ($rowset as $row) {
                        $result['list'][] = Pi::api('order', 'preorder')->canonizeOrder($row);
                    }


                    $result['status'] = 1;
                    $result['message'] = 'Its work !';
                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }
}