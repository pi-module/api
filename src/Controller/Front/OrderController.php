<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt BSD 3-Clause License
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
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    // Get list
                    $orders = Pi::api('order', 'order')->getOrderFromUser($uid, true);
                    $list   = [];
                    foreach ($orders as $order) {
                        $products     = Pi::api('order', 'order')->listProduct($order['id'], $order['module_name']);
                        $productsList = [];
                        $image        = '';
                        foreach ($products as $product) {
                            $productsList[] = $product['details']['title'];
                            $image          = $product['details']['thumbUrl'];
                        }
                        $list[$order['id']]             = $order;
                        $list[$order['id']]['products'] = implode(' , ', $productsList);
                        $list[$order['id']]['image']    = $image;
                    }
                    $result['list'] = array_values($list);

                    $result['status']  = 1;
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
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        $id     = $this->params('id');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    // Get list
                    $order = Pi::api('order', 'order')->getOrder($id);
                    if ($order['uid'] == $uid) {
                        $products     = Pi::api('order', 'order')->listProduct($order['id'], $order['module_name']);
                        $invoices     = Pi::api('invoice', 'order')->getInvoiceFromOrder($order['id'], false);
                        $productsList = [];
                        $image        = '';
                        foreach ($products as $product) {
                            $productsList[] = $product['details']['title'];
                            $image          = $product['details']['thumbUrl'];
                        }
                        $order['products']            = implode(' , ', $productsList);
                        $order['image']               = $image;
                        $order['invoices_count']      = count($invoices);
                        $order['invoices_count_view'] = _number(count($invoices));
                        foreach ($invoices as $invoice) {
                            $order['invoices'][] = $invoice;
                        }


                        $order = [$order];
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
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    // Get list
                    $invoiceList = Pi::api('invoice', 'order')->getInvoiceFromUser($uid, true);
                    $list        = [];
                    foreach ($invoiceList as $invoiceSingle) {
                        $order        = Pi::api('order', 'order')->getOrder($invoiceSingle['order']);
                        $products     = Pi::api('order', 'order')->listProduct($order['id'], $order['module_name']);
                        $productsList = [];
                        $image        = '';
                        foreach ($products as $product) {
                            $productsList[] = $product['details']['title'];
                            $image          = $product['details']['thumbUrl'];
                        }

                        //$list[$invoiceSingle['id']]['orderInfo'] = $order;
                        $list[$invoiceSingle['id']]             = $invoiceSingle;
                        $list[$invoiceSingle['id']]['products'] = implode(' , ', $productsList);
                        $list[$invoiceSingle['id']]['image']    = $image;
                    }
                    $result['list'] = array_values($list);


                    $result['status']  = 1;
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
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        $id     = $this->params('id');
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    // Get list
                    $invoice = Pi::api('invoice', 'order')->getInvoice($id);
                    if ($invoice['uid'] == $uid) {
                        $order        = Pi::api('order', 'order')->getOrder($invoice['order']);
                        $products     = Pi::api('order', 'order')->listProduct($order['id'], $order['module_name']);
                        $productsList = [];
                        $image        = '';
                        foreach ($products as $product) {
                            $productsList[] = $product['details']['title'];
                            $image          = $product['details']['thumbUrl'];
                        }
                        $invoice['products']  = implode(' , ', $productsList);
                        $invoice['image']     = $image;
                        $invoice['orderInfo'] = $order;
                        $invoice              = [$invoice];
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

    public function historyAction()
    {
        // Set result
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        $page   = $this->params('page', 1);
        $limit  = $this->params('limit', 25);
        // Check module
        if (Pi::service('module')->isActive('order')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    Pi::service('i18n')->load(['module/preorder', 'default']);


                    // Get info
                    $list   = [];
                    $order  = ['time_create DESC', 'id DESC'];
                    $offset = (int)($page - 1) * $limit;
                    $where  = ['uid' => $uid];
                    // Select
                    $select = Pi::model('history', 'order')->select()->where($where)->order($order)->offset($offset)->limit($limit);
                    $rowset = Pi::model('history', 'order')->selectWith($select);
                    // Make list
                    foreach ($rowset as $row) {
                        $history                    = $row->toArray();
                        $history['amount_view']     = Pi::api('api', 'order')->viewPrice($row->amount);
                        $history['amount_old_view'] = Pi::api('api', 'order')->viewPrice($row->amount_old);
                        $history['amount_new_view'] = Pi::api('api', 'order')->viewPrice($row->amount_new);

                        $history['time_create_view'] = _date($row->time_create);
                        switch ($row->status_fluctuation) {
                            case 'increase':
                                $history['status_fluctuation_view'] = __('Increase');
                                break;

                            case 'decrease':
                                $history['status_fluctuation_view'] = __('Decrease');
                                break;
                        }

                        switch ($row->status_action) {
                            case 'automatic':
                                $history['status_action_view'] = __('Automatic');
                                break;

                            case 'manual':
                                $history['status_action_view'] = __('Manual');
                                break;
                        }

                        $list[] = $history;
                    }
                    $result['history'] = $list;


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
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        // Check module
        if (Pi::service('module')->isActive('order') && Pi::service('module')->isActive('preorder')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    Pi::service('i18n')->load(['module/preorder', 'default']);

                    $result['list'] = [];
                    $where          = ['uid' => $uid, 'status' => [1, 2, 3, 7]];
                    $order          = ['time_create DESC', 'id DESC'];
                    $select         = Pi::model('order', 'preorder')->select()->where($where)->order($order);
                    $rowset         = Pi::model('order', 'preorder')->selectWith($select);
                    // Make list
                    foreach ($rowset as $row) {
                        $result['list'][] = Pi::api('order', 'preorder')->canonizeOrder($row);
                    }


                    $result['status']  = 1;
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

    public function preOrderSingleAction()
    {
        // Set result
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        $id     = $this->params('id');
        // Check module
        if (Pi::service('module')->isActive('order') && Pi::service('module')->isActive('preorder')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    Pi::service('i18n')->load(['module/preorder', 'default']);

                    // Get list
                    $preOrder = Pi::api('order', 'preorder')->getOrder($id);
                    if ($preOrder['uid'] == $uid) {

                        $i = 1;
                        foreach ($preOrder['basket'] as $basket) {
                            $preOrder['url_' . $i]   = $basket['url'];
                            $preOrder['title_' . $i] = $basket['title'];
                            $preOrder['price_' . $i] = Pi::api('api', 'order')->viewPrice($basket['price']);
                            $i++;
                        }

                        $preOrder = [$preOrder];
                        return $preOrder;
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

    public function plansAction()
    {
        // Set result
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');
        $uid    = $this->params('uid');
        $price  = $this->params('price');
        // Check module
        if (Pi::service('module')->isActive('order') && Pi::service('module')->isActive('preorder')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/order', 'default']);
                    Pi::service('i18n')->load(['module/preorder', 'default']);

                    // Set user
                    $user        = Pi::api('user', 'order')->getUserInformation($uid);
                    $user['uid'] = $user['id'];
                    unset($user['id']);

                    $installments = Pi::api('plan', 'preorder')->setPriceForView(($price * 10), $user);


                    foreach ($installments as $installment) {
                        if ($installment['id'] > 0) {
                            $result['plans'][] = [
                                'info'  => sprintf('%s - پیش پرداخت %s - مبلغ هر قسط %s',
                                    $installment['title'],
                                    Pi::api('api', 'order')->viewPrice($installment['invoices'][0]['price']),
                                    Pi::api('api', 'order')->viewPrice($installment['invoices'][1]['price'])),
                                'title' => $installment['title'],
                                'id'    => $installment['id'],
                            ];
                        } else {
                            $result['plans'][] = [
                                'info'  => $installment['title'],
                                'title' => $installment['title'],
                                'id'    => $installment['id'],
                            ];

                        }
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

    public function addAction()
    {
        // Set result
        $result = [
            'status'  => 0,
            'message' => '',
        ];
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token  = $this->params('token');

        $uid   = $this->params('uid');
        $price = $this->params('price');
        $url   = $this->params('url');
        $title = $this->params('title');
        $plan  = $this->params('plan');

        // Check module
        if (Pi::service('module')->isActive('order') && Pi::service('module')->isActive('preorder')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_order']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    if (!empty($uid) && is_numeric($uid)
                        && !empty($price) && is_numeric($price)
                        && !empty($plan) && is_numeric($plan)
                        && !empty($url) && filter_var($url, FILTER_VALIDATE_URL)
                        && !empty($title)
                    ) {

                        // Load language
                        Pi::service('i18n')->load(['module/order', 'default']);
                        Pi::service('i18n')->load(['module/preorder', 'default']);

                        // Set user
                        $user        = Pi::api('user', 'order')->getUserInformation($uid);
                        $user['uid'] = $user['id'];
                        unset($user['id']);

                        // Set order values
                        $values = [
                            'uid'         => $user['uid'],
                            'plan'        => intval($plan),
                            'time_create' => time(),
                            'status'      => 1,
                            'ip'          => Pi::user()->getIp(),
                            'id_number'   => $user['id_number'],
                            'first_name'  => $user['first_name'],
                            'last_name'   => $user['last_name'],
                            'email'       => $user['email'],
                            'phone'       => $user['phone'],
                            'mobile'      => $user['mobile'],
                            'address1'    => $user['address1'],
                            'address2'    => $user['address2'],
                            'country'     => $user['country'],
                            'state'       => $user['state'],
                            'city'        => $user['city'],
                            'zip_code'    => $user['zip_code'],
                            'company'     => $user['company'],
                        ];

                        // Save order
                        $orderRow = Pi::model('order', 'preorder')->createRow();
                        $orderRow->assign($values);
                        $orderRow->save();

                        // Save basket
                        $basketValues = [
                            'order' => $orderRow->id,
                            'uid'   => $orderRow->uid,
                            'title' => $title,
                            'url'   => $url,
                            'price' => $price * 10,
                        ];
                        $basketRow    = Pi::model('basket', 'preorder')->createRow();
                        $basketRow->assign($basketValues);
                        $basketRow->save();

                        // Canonize order
                        $orderSave = Pi::api('order', 'preorder')->canonizeOrder($orderRow);

                        // Notification
                        Pi::api('notification', 'preorder')->addOrder($orderSave);

                        // Set result
                        $result['status']  = 1;
                        $result['message'] = 'Its work !';
                    } else {
                        $result['message'] = __('Information not rue');
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
}