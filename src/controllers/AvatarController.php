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
            $path = dirname(__DIR__).self::UPLOAD_DIRECTORY;

            $img = $_FILES['file']['tmp_name'];
            $dst = $path.$this->getCurrentUser()->getEmail().".png";

            $img_info = getimagesize($img);

            switch ($img_info[2])
            {
                case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); break;
                case IMAGETYPE_PNG : $src = imagecreatefrompng($img); break;
            }

            $tmp = imagecreatetruecolor($img_info[0], $img_info[1]);
            imagesavealpha($tmp, true);
            $color = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
            imagefill($tmp, 0, 0, $color);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $img_info[0], $img_info[1], $img_info[0], $img_info[1]);
            imagepng($tmp, $dst);
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