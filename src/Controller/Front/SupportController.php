<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt BSD 3-Clause License
 */

namespace Module\Apis\Controller\Front;

use Module\Support\Form\TicketFilter;
use Module\Support\Form\TicketForm;
use Pi;
use Pi\Mvc\Controller\ActionController;
use Zend\Db\Sql\Predicate\Expression;

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
class SupportController extends ActionController
{
    public function listTicketAction()
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
        // Check module
        if (Pi::service('module')->isActive('support')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_support']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/support', 'default']);

                    $result = [
                        'uid'     => 0,
                        'count'   => 0,
                        'tickets' => [],
                    ];
                    // Get id
                    $uid = $this->params('uid');
                    if ($uid > 0) {
                        // Set info
                        $ticket = [];
                        $where  = ['mid' => 0, 'uid' => $uid];
                        $order  = ['time_update DESC', 'id DESC'];
                        // Get info
                        $select = Pi::model('ticket', 'support')->select()->where($where)->order($order);
                        $rowset = Pi::model('ticket', 'support')->selectWith($select);
                        foreach ($rowset as $row) {
                            $ticket[] = Pi::api('ticket', 'support')->canonizeTicket($row);
                        }
                        // Set count
                        $count  = ['count' => new Expression('count(*)')];
                        $select = Pi::model('ticket', 'support')->select()->columns($count)->where($where);
                        $count  = Pi::model('ticket', 'support')->selectWith($select)->current()->count;
                        // Set result
                        $result['tickets'] = $ticket;
                        $result['count']   = $count;
                        $result['uid']     = $uid;
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

    public function singleTicketAction()
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
        // Check module
        if (Pi::service('module')->isActive('support')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_support']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/support', 'default']);
                    $result = [];
                    // Get id
                    $id = $this->params('id');
                    // Get id
                    $uid = $this->params('uid');
                    if ($uid > 0) {
                        $user = Pi::user()->get($uid, ['id', 'identity', 'name', 'email']);
                        //
                        if ($id > 0) {
                            $result            = Pi::api('ticket', 'support')->getTicket($id);
                            $result['message'] = strip_tags($result['message']);

                            // Get list of replies
                            $tickets = [];
                            $where   = ['mid' => $id];
                            $order   = ['time_create ASC', 'id ASC'];
                            // Get info
                            $select = Pi::model('ticket', 'support')->select()->where($where)->order($order);
                            $rowset = Pi::model('ticket', 'support')->selectWith($select);
                            // Make list
                            foreach ($rowset as $row) {
                                $singleTicket            = Pi::api('ticket', 'support')->canonizeTicket($row);
                                $singleTicket['message'] = strip_tags($singleTicket['message']);
                                if ($uid == $row->uid) {
                                    $singleTicket['user_id']   = $user['id'];
                                    $singleTicket['user_name'] = $user['name'];
                                } else {
                                    $newUser                   = Pi::user()->get($row->uid, ['id', 'identity', 'name', 'email']);
                                    $singleTicket['user_id']   = $newUser['id'];
                                    $singleTicket['user_name'] = $newUser['name'];
                                }

                                $tickets[] = $singleTicket;
                            }
                            $result['tickets'] = $tickets;
                        } else {
                            $result['message'] = __('error 1');
                            $result['status']  = 0;
                        }
                    } else {
                        $result['message'] = __('error 2');
                        $result['status']  = 0;
                    }

                    return [$result];

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

    public function submitTicketAction()
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
        // Check module
        if (Pi::service('module')->isActive('support')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_support']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/support', 'default']);

                    $result = [];
                    if ($this->request->isPost()) {
                        $mid    = 0;
                        $status = 1;
                        // Get id
                        $id = $this->params('id');
                        // Get id
                        $uid = Pi::user()->getId();
                        if ($uid > 0) {
                            $user = Pi::user()->get($uid, ['id', 'identity', 'name', 'email']);
                            //
                            if ($id > 0) {
                                $ticketMain = Pi::api('ticket', 'support')->getTicket($id);
                            }

                            // Set option
                            $option = [
                                'attach' => 0,
                            ];
                            // Set form
                            $form = new TicketForm('ticket', $option);
                            $form->setAttribute('enctype', 'multipart/form-data');
                            $data = $this->request->getPost();
                            $form->setInputFilter(new TicketFilter);
                            $form->setData($data);
                            if ($form->isValid()) {
                                $values = $form->getData();
                                // Set values
                                $values['uid']         = $uid;
                                $values['time_create'] = time();
                                $values['time_update'] = time();
                                $values['ip']          = Pi::user()->getIp();
                                $values['mid']         = $mid;
                                $values['status']      = $status;
                                // Save
                                $row = Pi::model('ticket', 'support')->createRow();
                                $row->assign($values);
                                $row->save();
                                // Update main ticket status
                                if (isset($ticketMain['id']) && $id > 0) {
                                    Pi::model('ticket', 'support')->update(
                                        [
                                            'status'      => 3,
                                            'time_update' => time(),
                                        ],
                                        ['id' => $ticketMain['id']]
                                    );
                                    // User ticket
                                    $ticketUser = Pi::api('ticket', 'support')->canonizeTicket($row);
                                    // Send notification
                                    Pi::api('notification', 'support')->supportTicket($ticketMain, 'reply', $ticketUser['message']);
                                    // Update user info
                                    Pi::api('user', 'support')->updateUser($uid, 'reply');
                                } else {
                                    // Set ticket
                                    $ticketMain         = Pi::api('ticket', 'support')->canonizeTicket($row);
                                    $ticketMain['user'] = $user;
                                    // Send notification
                                    Pi::api('notification', 'support')->supportTicket($ticketMain, 'open');
                                    // Update user info
                                    Pi::api('user', 'support')->updateUser($uid, 'ticket');
                                }
                                $result['message'] = __('Your support ticket submit successfully, we will answer you very soon');
                                $result['status']  = 1;
                            } else {
                                $result['message'] = __('error 1');
                                $result['status']  = 0;
                            }
                        } else {
                            $result['message'] = __('error 2');
                            $result['status']  = 0;
                        }
                    } else {
                        $result['message'] = __('error 3');
                        $result['status']  = 0;
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