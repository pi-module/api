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

use TelegramBot\Api\BotApi as TelegramBotApi;
use TelegramBot\Api\Client as TelegramClient;
use TelegramBot\Api\Exception as TelegramException;

//require_once '/var/www/html/local/pi/pi260/lib/vendor/telegram/autoload.php';

/**
 * Cron controller
 *
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
class TelegramController extends ActionController
{
    public function indexAction()
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
        // Check config
        $config = Pi::service('registry')->config->read($module);
        if ($config['active_telegram']) {
            // Check token
            $check = Pi::api('token', 'tools')->check($token, $module, 'api');
            if ($check['status'] == 1) {



                try {
                    $bot = new TelegramClient($config['telegram_api_key']);
                    $bot->command('ping', function ($message) use ($bot) {
                        $bot->sendMessage($message->getChat()->getId(), 'pong!');
                    });
                    $result = $bot->run();
                } catch (TelegramException $e) {
                    $result['message'] = $e->getMessage();
                }

                return $result;
            } else {
                return $check;
            }
        } else {
            return $result;
        }
    }

}