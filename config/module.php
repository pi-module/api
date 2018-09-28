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
return [
    // Module meta
    'meta'       => [
        'title'       => _a('APIs'),
        'description' => _a('Api system of mobile apps and external service'),
        'version'     => '0.1.2',
        'license'     => 'New BSD',
        'logo'        => 'image/logo.png',
        'readme'      => 'docs/readme.txt',
        'demo'        => 'http://piengine.org',
        'icon'        => 'fa-code',
    ],
    // Dependency
    'dependency' => [
        'tools',
    ],
    // Author information
    'author'     => [
        'Name'    => 'Hossein Azizabadi',
        'email'   => 'azizabadi@faragostaresh.com',
        'website' => 'http://piengine.org',
        'credits' => 'Pi Engine Team',
    ],
    // Resource
    'resource'   => [
        'config'     => 'config.php',
        'permission' => 'permission.php',
        'page'       => 'page.php',
        'navigation' => 'navigation.php',
    ],
];
