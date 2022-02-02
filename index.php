<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get("", 'DefaultController');
Routing::get('statistics', 'DefaultController');
Routing::get('fetchGetSkill', 'SkillController');
Routing::get('fetchGetUser', 'UserController');
Routing::get('fetchGetUserStats', 'UserController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::post('changeAvatar', 'AvatarController');
Routing::post('fetchAddSkill', 'SkillController');
Routing::post('fetchAdvanceSkill', 'SkillController');
Routing::post('fetchAdvanceAttribute', 'UserController');
Routing::delete('fetchDeleteSkill', 'SkillController');

Routing::run($path);