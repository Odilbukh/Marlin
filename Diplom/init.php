<?php
session_start();
date_default_timezone_set('UTC+5');

require_once 'classes/database.php';
require_once 'classes/config.php';
require_once 'classes/validate.php';
require_once 'classes/input.php';
require_once 'classes/token.php';
require_once 'classes/session.php';
require_once 'classes/user.php';
require_once 'classes/redirect.php';
require_once 'classes/cookie.php';

$GLOBALS['config'] =
    [
        'mysql' =>
            [
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'root',
                'database' => 'marlin_3',
            ],

        'session'  =>  [
            'token_name'    =>  'token',
            'user_session'  =>  'user'
        ],

        'cookie'    =>  [
            'cookie_name'   =>  'hash',
            'cookie_expiry' =>  604800
        ]
    ];

if(Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.user_session'))) {
    $hash = Cookie::get(Config::get('cookie.cookie_name'));
    $hashCheck = Database::getInstance()->get('user_sessions', ['hash', '=', $hash]);

    if($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}