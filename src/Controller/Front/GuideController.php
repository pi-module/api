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
class GuideController extends ActionController
{
    public function itemListAction()
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
        if (Pi::service('module')->isActive('guide')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_guide']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('guide', 'list', 0, [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $options                = [];
                    $options['page']        = $this->params('page', 1);
                    $options['title']       = $this->params('title');
                    $options['category']    = $this->params('category');
                    $options['location']    = $this->params('location');
                    $options['tag']         = $this->params('tag');
                    $options['favourite']   = $this->params('favourite');
                    $options['recommended'] = $this->params('recommended');
                    $options['discount']    = $this->params('discount');
                    $options['people']      = $this->params('people');
                    $options['limit']       = $this->params('limit');
                    $options['order']       = $this->params('order');

                    $result = Pi::api('api', 'guide')->itemList($options);

                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        }
    }

    public function itemSingleAction()
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
        if (Pi::service('module')->isActive('guide')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_guide']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('guide', 'single', $this->params('id'), [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $id     = $this->params('id');
                    $result = Pi::api('api', 'guide')->itemSingle($id);

                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        }
    }

    public function mapAction()
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
        if (Pi::service('module')->isActive('guide')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_guide']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('guide', 'map', 0, [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $latitude  = $this->params('latitude');
                    $longitude = $this->params('longitude');

                    $result['list']    = Pi::api('api', 'guide')->itemMap($latitude, $longitude);
                    $result['status']  = 1;
                    $result['message'] = 'Its work !';

                    return $result;
                } else {
                    return $check;
                }
            } else {
                return $result;
            }
        }
    }
}