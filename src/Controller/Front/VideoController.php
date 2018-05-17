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
class VideoController extends ActionController
{
    public function videoListAction()
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
        if (Pi::service('module')->isActive('video')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_video']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('video', 'list', 0, [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $params                = [];
                    $params['page']        = $this->params('page', 1);
                    $params['title']       = $this->params('title');
                    $params['category']    = $this->params('category');
                    $params['tag']         = $this->params('tag');
                    $params['favourite']   = $this->params('favourite');
                    $params['recommended'] = $this->params('recommended');
                    $params['limit']       = $this->params('limit');
                    $params['order']       = $this->params('order');
                    $params['channel']     = $this->params('channel');
                    $result                = Pi::api('api', 'video')->videoList($params);
                    $result['status']      = 1;
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

    public function videoSingleAction()
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
        if (Pi::service('module')->isActive('video')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_video']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('video', 'single', $this->params('id'), [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $params         = [];
                    $params['id']   = $this->params('id');
                    $params['slug'] = $this->params('slug');
                    $result         = Pi::api('api', 'video')->videoSingle($params);

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

    public function categoryListAction()
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
        if (Pi::service('module')->isActive('video')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_video']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('video', 'category', 0, [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $params           = [];
                    $result           = Pi::api('api', 'video')->categoryList($params);
                    $result['status'] = 1;
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

    public function setAccessAction()
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
        if (Pi::service('module')->isActive('video')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_video']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {
                    $params        = [];
                    $params['id']  = $this->params('id');
                    $params['uid'] = $this->params('uid');
                    return Pi::api('api', 'video')->setAccess($params);
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