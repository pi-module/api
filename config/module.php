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
    // Module meta
    'meta' => array(
        'title'        => _a('APIs'),
        'description'  => _a('Api system of mobile apps and external service'),
        'version'      => '0.0.4',
        'license'      => 'New BSD',
        'logo'         => 'image/logo.png',
        'readme'       => 'docs/readme.txt',
        'demo'         => 'http://pialog.org',
        'icon'         => 'fa-code',
    ),
    // Dependency
    'dependency' => array(
        'tools',
    ),
    // Author information
    'author' => array(
        'Name'         => 'Hossein Azizabadi',
        'email'        => 'azizabadi@faragostaresh.com',
        'website'      => 'http://pialog.org',
        'credits'      => 'Pi Engine Team'
    ),
    // Resource
    'resource' => array(
        'config'       => 'config.php',
        'permission'   => 'permission.php',
        'page'         => 'page.php',
        'navigation'   => 'navigation.php',
    ),
);
