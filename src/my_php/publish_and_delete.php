<?php
require_once '../include/session_start.php';

if (isset($_POST['publish']))
{
    $file = htmlspecialchars($_POST['publish']);
    $time = time();
    $pdo = myPDO::getInstance();
    $query = "
        INSERT INTO `gallery` (`image_url`, `user_id`, `date_time_photo`, likes, like_count, comments)
        VALUES (:image_url, :user_id, :date_time_photo, :likes, :like_count, :comments)
        ";
    $sql = $pdo->prepare($query);
    $sql->execute(
        array(
            ':image_url'       => $file,
            ':user_id'         => $_SESSION["user_id"],
            ':date_time_photo' => $time,
            ':likes'           => 0,
            ':like_count'     => -1,
            ':comments'        => 0
            )
        );
    $count_image = $sql->rowCount();
    if ($count_image > 0)
    {
        $arr = ["success" => "Picture has been saved."];
        echo json_encode($arr);
    }
}
else if (isset($_POST['cancel']))
{
    $file = $_POST['cancel'];
    if (file_exists($file))
    {
        unlink($file);
        $arr = ["success" => " Picture has been cancelled."];
        echo json_encode($arr);
    }
        
}