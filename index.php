<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get("", 'DefaultController');
Routing::get('statistics', 'DefaultController');
Routing::get('quests', 'DefaultController');
Routing::get('fetchGetSkill', 'SkillController');
Routing::get('fetchGetQuests', 'QuestController');
Routing::get('fetchGetUser', 'UserController');
Routing::get('fetchGetUserStats', 'UserController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::post('changeAvatar', 'AvatarController');
Routing::post('fetchAddSkill', 'SkillController');
Routing::post('fetchAddQuest', 'QuestController');
Routing::post('fetchAdvanceSkill', 'SkillController');
Routing::post('fetchCompleteQuest', 'QuestController');
Routing::post('fetchAdvanceAttribute', 'UserController');
Routing::delete('fetchDeleteSkill', 'SkillController');
Routing::delete('fetchDeleteQuest', 'QuestController');

Routing::run($path);