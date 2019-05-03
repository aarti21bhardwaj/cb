<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakePdf' => $baseDir . '/vendor/friendsofcake/cakepdf/',
        'Cewi/Excel' => $baseDir . '/vendor/Cewi/Excel/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'InspiniaTheme' => $baseDir . '/vendor/integrateideas/inspiniaTheme/',
        'Josegonzalez/Upload' => $baseDir . '/vendor/josegonzalez/cakephp-upload/',
        'MailgunEmail' => $baseDir . '/vendor/narendravaghela/cakephp-mailgun/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Muffin/Trash' => $baseDir . '/vendor/muffin/trash/',
        'Robotusers/Excel' => $baseDir . '/vendor/robotusers/cakephp-excel/',
        'WyriHaximus/TwigView' => $baseDir . '/vendor/wyrihaximus/twig-view/'
    ]
];