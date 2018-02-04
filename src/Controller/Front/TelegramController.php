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
use TelegramBot\Api\Exception as TelegramException;
use TelegramBot\Api\Types\ReplyKeyboardMarkup as TelegramReplyKeyboardMarkup;

//require_once '/var/www/html/local/pi/pi260/lib/vendor/telegram/autoload.php';

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
class TelegramController extends ActionController
{
    public function indexAction()
    {
        Pi::service('audit')->log('telegram', $_REQUEST);
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
        // Check config
        $config = Pi::service('registry')->config->read($module);
        if ($config['active_external']) {
            // Check token
            $check = Pi::api('token', 'tools')->check($token, $module, 'api');
            if ($check['status'] == 1) {

                $telegram = json_decode(file_get_contents('php://input'));
                $message  = $telegram["message"];
                $chatId   = $message["chat"]["id"];

                Pi::service('audit')->log('telegram', $telegram);
                Pi::service('audit')->log('telegram', $message);
                Pi::service('audit')->log('telegram', $chatId);

                try {
                    $bot      = new TelegramBotApi($config['telegram_api_key']);
                    $keyboard = new TelegramReplyKeyboardMarkup([["one", "two", "three"]], true);
                    $bot->sendMessage($chatId, "Test", false, null, $keyboard);
                } catch (TelegramException $e) {
                    $e->getMessage();
                }

            } else {
                return $check;
            }
        } else {
            return $result;
        }
    }
}