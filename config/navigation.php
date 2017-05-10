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
    'front' => false,
    'admin' => array(
        'list' => array(
            'label'        => _a('Api list'),
            'permission'   => array(
                'resource' => 'list',
            ),
            'route'        => 'admin',
            'module'       => 'apis',
            'controller'   => 'list',
            'action'       => 'index',
        ),
    ),
);