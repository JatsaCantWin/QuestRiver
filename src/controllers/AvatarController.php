<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class AvatarController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploadedAvatars/';

    private $messages = [];

    public function changeAvatar()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file']))
        {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            return $this->render('statistics', ['messages' => $this->messages]);
        }
        $this->render('statistics', ['messages' => $this->messages]);
        echo "<script>document.getElementById(\"avatarModal\").style.display = \"flex\";</script>";
    }

    private function validate(array $file)
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large.';
            return false;
        }
        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'Unsupported filetype';
            return false;
        }

        return true;
    }
}