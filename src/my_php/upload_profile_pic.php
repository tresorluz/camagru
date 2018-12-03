<?php
require_once '../include/session_start.php';

    if (isset($_POST['base64']) && isset($_POST['type']))
    {
         if (!is_dir('../../users_pics'))
         {
            mkdir('../../users_pics');
            if (!is_dir('../../users_pics/'.$login))
            mkdir('../../users_pics/'.$login);
         }
           
         else
         {
         if (!is_dir('../../users_pics/'.$login))
             mkdir('../../users_pics/'.$login);
         }
         $query = "
         SELECT profile_pic_url
         FROM users 
         WHERE user_id=:user_id;
         ";
         $sql = $pdo->prepare($query);
         $sql->execute(
         array(
             ':user_id' => $_SESSION['user_id']
         )
         );
        $count = $sql->rowCount();
        if ($count > 0)
        {
            $result = $sql->fetchAll();
            foreach($result as $row)
                $photo_old = $row['profile_pic_url'];
        }
        $name_img = md5(rand());
        $data = str_replace(" ", "+", $_POST['base64']);
        $plainText = base64_decode($data);
        if ($_POST['type'] == 'png')
            $filename = '../../users_pics/'.$login.'/'.$name_img.'.png';
        else
            $filename = '../../users_pics/'.$login.'/'.$name_img.'.jpeg';
        file_put_contents($filename, $plainText);
        if (exif_imagetype($filename) == IMAGETYPE_JPEG || exif_imagetype($filename) == IMAGETYPE_PNG)
        {
            $query = "
            UPDATE users SET profile_pic_url=:profile_pic_url WHERE user_id=:user_id;
            ";
            $sql = $pdo->prepare($query);
            $sql->execute(
            array(
                ':profile_pic_url'     => $filename,
                ':user_id'              => $_SESSION['user_id']
            )
            );
            $count = $sql->rowCount();
            if ($count > 0)
            {
                if (file_exists($photo_old))
                unlink($photo_old);
                $arr = ["file" => $filename];
                echo json_encode($arr);
            }
        }
    }
?>