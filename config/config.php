<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */

return array(
    'category' => array(
        array(
            'name'      => 'active',
            'title'     => _t('Active'),
        ),
        array(
            'name'      => 'setting',
            'title'     => _t('Setting'),
        ),
    ),
    'item' => array(
        // Active
        'active_user' => array(
            'category'      => 'active',
            'title'         => _a('Active user'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_page' => array(
            'category'      => 'active',
            'title'         => _a('Active page'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_news' => array(
            'category'      => 'active',
            'title'         => _a('Active news'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_event' => array(
            'category'      => 'active',
            'title'         => _a('Active event'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_video' => array(
            'category'      => 'active',
            'title'         => _a('Active video'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_shop' => array(
            'category'      => 'active',
            'title'         => _a('Active shop'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_guide' => array(
            'category'      => 'active',
            'title'         => _a('Active guide'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_contact' => array(
            'category'      => 'active',
            'title'         => _a('Active contact'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_support' => array(
            'category'      => 'active',
            'title'         => _a('Active support'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_telegram' => array(
            'category'      => 'active',
            'title'         => _a('Active telegram'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        // Setting
        'telegram_api_key' => array(
            'category' => 'setting',
            'title' => _a('Telegram api key'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'string',
        ),
    ),
);