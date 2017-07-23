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
class RegisterController extends ActionController
{
    public function indexAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => __('Error on register'),
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        // Check module
        if (Pi::service('module')->isActive('user')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_register']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {



                    // Load language
                    Pi::service('i18n')->load(array('module/user', 'default'));

                    $values = array();
                    $request = array();
                    if (isset($_POST) && !empty($_POST)) {
                        $request = $_POST;
                    } if (isset($_GET) && !empty($_GET)) {
                        $request = $_GET;
                    }
                    foreach ($request as $key => $value) {
                        $key = _escape($key);
                        $value = _strip($value);
                        $values[$key] = $value;
                    }

                    // Check mobile force set on register form
                    if (!isset($values['mobile']) || empty($values['mobile']) || !is_numeric($values['mobile'])) {
                        return $result;
                    }
                    // Check email force set on register form
                    if (!isset($values['email']) || empty($values['email'])) {
                        $values['email'] = '';
                    }
                    // Set email as identity if not set on register form
                    if (!isset($values['identity']) || empty($values['identity'])) {
                        $values['identity'] = $values['mobile'];
                    }
                    // Set name if not set on register form
                    if (!isset($values['name']) || empty($values['name'])) {
                        if (isset($values['first_name']) || isset($values['last_name'])) {
                            $values['name'] = $values['first_name'] . ' ' . $values['last_name'];
                        } else {
                            $values['name'] = $values['identity'];
                        }
                    }
                    // Set values
                    $values['last_modified'] = time();
                    $values['ip_register']   = Pi::user()->getIp();

                    // Add user
                    $uid = Pi::api('user', 'user')->addUser($values);
                    if (!$uid || !is_int($uid)) {
                        $result = array(
                            'status' => 0,
                            'message' => __('User account was not saved.'),
                        );
                    } else {
                        // Set user role
                        Pi::api('user', 'user')->setRole($uid, 'member');

                         // Active user
                        $status = Pi::api('user', 'user')->activateUser($uid);
                        if ($status) {
                            // Target activate user event
                            Pi::service('event')->trigger('user_activate', $uid);
                            //
                            $result = array(
                                'status' => 1,
                                'message' => __('Your account create and activate. please login to system'),
                            );
                            return $result;
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

    public function editAction()
    {
        // Set result
        $result = array(
            'status' => 0,
            'message' => __('Error on register'),
        );
        // Set template
        $this->view()->setTemplate(false)->setLayout('layout-content');
        // Get info from url
        $module = $this->params('module');
        $token = $this->params('token');
        // Check module
        if (Pi::service('module')->isActive('user')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_register']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {



                    // Load language
                    Pi::service('i18n')->load(array('module/user', 'default'));

                    $values = array();
                    $request = array();
                    if (isset($_POST) && !empty($_POST)) {
                        $request = $_POST;
                    } if (isset($_GET) && !empty($_GET)) {
                        $request = $_GET;
                    }
                    foreach ($request as $key => $value) {
                        $key = _escape($key);
                        $value = _strip($value);
                        $values[$key] = $value;
                    }

                    // Set uid
                    if (!empty($values['uid'])) {
                        $uid = $values['uid'];
                        unset($values['uid']);
                    } else {
                        return $result;
                    }

                    // Fields
                    $fields = Pi::api('user', 'user')->getFields($uid, 'profile');
                    // Set just needed fields
                    foreach (array_keys($values) as $key) {
                        if (!in_array($key, array_keys($fields))) {
                            unset($values[$key]);
                        }
                    }
                    // From user module
                    $values['last_modified'] = time();
                    if (isset($values['first_name']) || isset($values['last_name'])) {
                        $values['name'] = $values['first_name'] . ' ' . $values['last_name'];
                    }

                    $status = Pi::api('user', 'user')->updateUser($uid, $values);
                    if ($status == 1) {
                        Pi::service('event')->trigger('user_update', $uid);
                    }

                    $result = array(
                        'status' => 1,
                        'message' => __('Your account information update'),
                    );







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