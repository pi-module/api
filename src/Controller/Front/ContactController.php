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
class ContactController extends ActionController
{
    public function sendAction()
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
        if (Pi::service('module')->isActive('contact')) {
            // Check config
            $config = Pi::service('registry')->config->read($module);
            if ($config['active_contact']) {
                // Check token
                $check = Pi::api('token', 'tools')->check($token, $module, 'api');
                if ($check['status'] == 1) {


                    // Load language
                    Pi::service('i18n')->load(['module/contact', 'default']);

                    // Check post
                    if ($this->request->isPost()) {
                        $data             = $this->request->getPost();
                        $data['platform'] = 'mobile';
                        $result           = Pi::api('api', 'contact')->contact($data);
                    } else {
                        $result['message'] = __('Nothing send');
                        $result['submit']  = 0;
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