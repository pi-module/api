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

return [
    'category' => [
        [
            'name'  => 'active',
            'title' => _t('Active'),
        ],
        [
            'name'  => 'setting',
            'title' => _t('Setting'),
        ],
    ],
    'item'     => [
        // Active
        'active_user'      => [
            'category'    => 'active',
            'title'       => _a('Active user'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_register'  => [
            'category'    => 'active',
            'title'       => _a('Active register'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_page'      => [
            'category'    => 'active',
            'title'       => _a('Active page'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_news'      => [
            'category'    => 'active',
            'title'       => _a('Active news'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_event'     => [
            'category'    => 'active',
            'title'       => _a('Active event'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_video'     => [
            'category'    => 'active',
            'title'       => _a('Active video'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_shop'      => [
            'category'    => 'active',
            'title'       => _a('Active shop'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_guide'     => [
            'category'    => 'active',
            'title'       => _a('Active guide'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_contact'   => [
            'category'    => 'active',
            'title'       => _a('Active contact'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_support'   => [
            'category'    => 'active',
            'title'       => _a('Active support'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_order'     => [
            'category'    => 'active',
            'title'       => _a('Active order'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_portfolio' => [
            'category'    => 'active',
            'title'       => _a('Active portfolio'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_forms'     => [
            'category'    => 'active',
            'title'       => _a('Active forms'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'active_external'  => [
            'category'    => 'active',
            'title'       => _a('Active external services / modules'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        // Setting
        'login_field' => [
            'title'       => _t('Login field'),
            'description' => _t('Identity field(s) for authentication.'),
            'edit'        => [
                'type'       => 'select',
                'attributes' => [
                    'multiple' => true,
                ],
                'options'    => [
                    'value_options' => [
                        'identity' => _t('Username'),
                        'email'    => _t('Email'),
                    ],
                ],
            ],
            'filter'      => 'array',
            'value'       => ['identity'],
            'category'    => 'login',
        ],

        'telegram_api_key' => [
            'category'    => 'setting',
            'title'       => _a('Telegram api key'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'string',
        ],
    ],
];