<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

namespace Module\Apis\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;

class ListController extends ActionController
{
    public function indexAction()
    {
        // Get info from url
        $module = $this->params('module');
        // Get toke list
        $tokens = Pi::api('token', 'tools')->getList($module, 'api');
        // Set link list
        $links = [];
        // Make list
        if (!empty($tokens)) {
            foreach ($tokens as $token) {
                // Add telegram on list
                $links['telegram'][$token['id']] = [
                    'name'  => 'telegram',
                    'title' => sprintf('%s ( Token : %s )', __('Telegram'), $token['title']),
                    'url'   => Pi::url($this->url('default', [
                        'module'     => 'apis',
                        'controller' => 'telegram',
                        'action'     => 'index',
                        'token'      => $token['token'],
                    ])),
                ];
                // Add contact on list
                $links['contact'][$token['id']] = [
                    'name'  => 'contact',
                    'title' => sprintf('%s ( Token : %s )', __('Contact'), $token['title']),
                    'url'   => Pi::url($this->url('default', [
                        'module'     => 'apis',
                        'controller' => 'contact',
                        'action'     => 'send',
                        'token'      => $token['token'],
                    ])),
                ];
            }
        }


        // Set template
        $this->view()->setTemplate('list-index');
        $this->view()->assign('tokens', $tokens);
        $this->view()->assign('links', $links);
    }
}