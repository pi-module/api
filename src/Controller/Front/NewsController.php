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
class NewsController extends ActionController
{
    public function listAction()
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
        if (Pi::service('module')->isActive('news')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_news']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('news', 'list', 0, [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $options            = [];
                    $options['page']    = $this->params('page', 1);
                    $options['title']   = $this->params('title');
                    $options['topic']   = $this->params('topic');
                    $options['tag']     = $this->params('tag');
                    $options['limit']   = $this->params('limit');
                    $options['getUser'] = true;
                    $result             = Pi::api('api', 'news')->jsonList($options);


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

    public function singleAction()
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
        if (Pi::service('module')->isActive('news')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_news']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('news', 'single', $this->params('id'), [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $id     = $this->params('id');
                    $result = Pi::api('api', 'news')->jsonSingle($id, true);

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

    public function submitAction()
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
        if (Pi::service('module')->isActive('news')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_news']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    if ($this->request->isPost()) {
                        $data   = $this->request->getPost();
                        $result = Pi::api('api', 'news')->jsonSubmit($data);
                        if ($result['status'] == 1) {
                            $result['message'] = __('Story save on DB, waiting to admin review and publish it');
                        } else {
                            $result['message'] = __('Error to save story');
                        }
                    } else {
                        $result['message'] = __('Nothing send');
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