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
class PortfolioController extends ActionController
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
        if (Pi::service('module')->isActive('portfolio')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_portfolio']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('portfolio', 'list', 0, [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $page        = $this->params('page', 1);
                    $limit       = $this->params('limit', 15);
                    $projectList = [];

                    // Set
                    $where  = ['status' => 1];
                    $order  = ['time_create DESC', 'id DESC'];
                    $offset = (int)($page - 1) * $limit;

                    // Get info
                    $select = Pi::model('project', 'portfolio')->select()->where($where)->order($order)->offset($offset)->limit($limit);
                    $rowset = Pi::model('project', 'portfolio')->selectWith($select);
                    // Make list
                    foreach ($rowset as $row) {
                        $projectList[] = Pi::api('project', 'portfolio')->canonizeProject($row);
                    }

                    $result['projectList'] = $projectList;


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
        if (Pi::service('module')->isActive('portfolio')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_portfolio']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {

                    // Save statistics
                    if (Pi::service('module')->isActive('statistics')) {
                        Pi::api('log', 'statistics')->save('portfolio', 'single', $this->params('id'), [
                            'source'  => $this->params('platform'),
                            'section' => 'api',
                        ]);
                    }

                    $id = $this->params('id');

                    $result = Pi::api('project', 'portfolio')->getProject($id);
                    $result = [$result];

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