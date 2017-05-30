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
use Pi\Authentication\Result;
use Pi\Mvc\Controller\ActionController;

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
class UserController extends ActionController
{
    public function checkAction()
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
        // Check module
        if (Pi::service('module')->isActive('user')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_user']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Get session id
                    $id = $this->params('id', '');

                    // Check id set or not
                    if (!empty($id)) {
                        // Start session
                        $session = Pi::model('session')->find($id);
                        if ($session) {
                            // Old method for pi 2.4.0
                            /*
                            session_id($id);
                            Pi::service('session')->manager()->start();
                            */
                            // New method for pi 2.5.0
                            $session = $session->toArray();
                            Pi::service('session')->manager()->start(false, $session['id']);
                        }
                    }

                    // Check user has identity
                    if (Pi::service('user')->hasIdentity()) {
                        // Get user
                        $user = Pi::user()->get(Pi::user()->getId(), array(
                            'id', 'identity', 'name', 'email'
                        ));
                        // Set result
                        $result = array(
                            'check' => 1,
                            'uid' => $user['id'],
                            'identity' => $user['identity'],
                            'email' => $user['email'],
                            'name' => $user['name'],
                            'avatar' => Pi::service('user')->avatar($user['id'], 'large', false),
                            'sessionid' => Pi::service('session')->getId(),
                        );
                    } else {
                        $result = array(
                            'check' => 0,
                            'uid' => Pi::user()->getId(),
                            'identity' => Pi::user()->getIdentity(),
                            'email' => '',
                            'name' => '',
                            'avatar' => '',
                            'sessionid' => Pi::service('session')->getId(),
                        );
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

    public function loginAction()
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
        // Check module
        if (Pi::service('module')->isActive('user')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_user']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    if (Pi::service('user')->hasIdentity()) {
                        // Get user
                        $user = Pi::user()->get(Pi::user()->getId(), array(
                            'id', 'identity', 'name', 'email'
                        ));
                        // Set result
                        $result = array(
                            'check' => 1,
                            'uid' => $user['id'],
                            'identity' => $user['identity'],
                            'email' => $user['email'],
                            'name' => $user['name'],
                            'avatar' => Pi::service('user')->avatar($user['id'], 'large', false),
                            'sessionid' => Pi::service('session')->getId(),
                            'message' => __('You are login to system before'),
                        );
                    } else {

                        // Check post array set or not
                        if (!$this->request->isPost()) {
                            // Set result
                            $result = array(
                                'check' => 0,
                                'uid' => Pi::user()->getId(),
                                'identity' => Pi::user()->getIdentity(),
                                'email' => '',
                                'name' => '',
                                'avatar' => '',
                                'sessionid' => Pi::service('session')->getId(),
                                'message' => __('Post request not set'),
                            );
                        } else {
                            // Get from post
                            $post = $this->request->getPost();
                            $identity = $post['identity'];
                            $credential = $post['credential'];
                            // Do login
                            $result = $this->doLogin($identity, $credential);
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

    public function logoutAction()
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
        // Check module
        if (Pi::service('module')->isActive('user')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_user']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Get user id
                    $uid = Pi::user()->getId();
                    // Logout user actions
                    Pi::service('session')->manager()->destroy();
                    Pi::service('user')->destroy();
                    Pi::service('event')->trigger('logout', $uid);
                    // Set retrun array
                    $result = array(
                        'message' => __('You logged out successfully.'),
                        'logout' => 1,
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


    public function profileAction()
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
        // Check module
        if (Pi::service('module')->isActive('user')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_user']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Get session id
                    $id = $this->params('id', '');
                    // Check id set or not
                    if (!empty($id)) {
                        // Start session
                        $session = Pi::model('session')->find($id);
                        if ($session) {
                            // Old method for pi 2.4.0
                            /*
                            session_id($id);
                            Pi::service('session')->manager()->start();
                            */
                            // New method for pi 2.5.0
                            $session = $session->toArray();
                            Pi::service('session')->manager()->start(false, $session['id']);
                        }
                    }
                    if (Pi::service('user')->hasIdentity()) {
                        $fields = array(
                            'id', 'identity', 'name', 'email', 'first_name', 'last_name', 'id_number', 'phone', 'mobile',
                            'address1', 'address2', 'country', 'state', 'city', 'zip_code', 'company', 'company_id', 'company_vat',
                            'your_gift', 'your_post', 'company_type', 'latitude', 'longitude',
                        );
                        // Find user
                        $uid = Pi::user()->getId();
                        $result = Pi::user()->get($uid, $fields);
                        $result['avatar'] = Pi::service('avatar')->get($result['id'], 'large', false);
                        $result['uid'] = $uid;
                        $result['check'] = 1;
                        $result['sessionid'] = Pi::service('session')->getId();

                        if (Pi::service('module')->isActive('support')) {
                            $result['support'] = Pi::api('ticket', 'support')->getCount($uid);
                        }
                    } else {
                        $result = array(
                            'check' => 0,
                            'uid' => Pi::user()->getId(),
                            'identity' => Pi::user()->getIdentity(),
                            'email' => '',
                            'name' => '',
                            'avatar' => '',
                            'sessionid' => Pi::service('session')->getId(),
                        );
                    }

                    // json output
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

    public function doLogin($identity, $credential)
    {
        // Set return array
        $return = array(
            'message' => '',
            'login' => 0,
            'identity' => '',
            'email' => '',
            'name' => '',
            'avatar' => '',
            'uid' => 0,
            'userid' => 0,
            'sessionid' => '',
            'error' => 0,
            'check' => 0
        );

        // Set field
        $field = 'identity';
        if (Pi::service('module')->isActive('user')) {
            $config = Pi::service('registry')->config->read('user');
            $field = $config['login_field'];
            $field = array_shift($field);
        }

        // try login
        $result = Pi::service('authentication')->authenticate(
            $identity,
            $credential,
            $field
        );
        $result = $this->verifyResult($result);

        // Check login is valid
        if ($result->isValid()) {
            $uid = (int)$result->getData('id');
            // Bind user information
            if (Pi::service('user')->bind($uid)) {
                Pi::service('session')->setUser($uid);
                $rememberMe = 14 * 86400;
                Pi::service('session')->manager()->rememberme($rememberMe);
                // Unset login session
                if (isset($_SESSION['PI_LOGIN'])) {
                    unset($_SESSION['PI_LOGIN']);
                }
                // Set user login event
                $args = array(
                    'uid' => $uid,
                    'remember_time' => $rememberMe,
                );
                Pi::service('event')->trigger('user_login', $args);
                // Get user information
                //$user = Pi::model('user_account')->find($uid)->toArray();
                $user = Pi::user()->get($uid, array(
                    'id', 'identity', 'name', 'email'
                ));
                // Set return array
                $return['message'] = __('You have logged in successfully');
                $return['login'] = 1;
                $return['identity'] = $user['identity'];
                $return['email'] = $user['email'];
                $return['name'] = $user['name'];
                $return['avatar'] = Pi::service('user')->avatar($user['id'], 'medium', false);
                $return['uid'] = $user['id'];
                $return['userid'] = $user['id'];
                $return['sessionid'] = Pi::service('session')->getId();
                $return['check'] = 1;
            } else {
                $return['error'] = 1;
                $return['message'] = __('Bind error');
            }
        } else {
            $return['error'] = 1;
            $return['message'] = __('Authentication is not valid');
        }

        return $return;
    }

    protected function verifyResult(Result $result)
    {
        return $result;
    }
}