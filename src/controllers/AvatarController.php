<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class AvatarController extends AppController
{
    public function changeAvatar()
    {
        $this->render('change-avatar');
    }
}