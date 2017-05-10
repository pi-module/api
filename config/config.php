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
    ),
    'item' => array(
        'active_telegram' => array(
            'category'      => 'active',
            'title'         => _a('Active telegram'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_contact' => array(
            'category'      => 'active',
            'title'         => _a('Active telegram'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_support' => array(
            'category'      => 'active',
            'title'         => _a('Active telegram'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
        'active_news' => array(
            'category'      => 'active',
            'title'         => _a('Active telegram'),
            'description'   => '',
            'edit'          => 'checkbox',
            'filter'        => 'number_int',
            'value'         => 1
        ),
    ),
);