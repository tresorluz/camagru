<?php
require_once '../include/session_start.php';
if ($_POST['imageId']) {
    if (isset($_SESSION['user_id']))
    {
        $pdo = myPDO::getInstance();
        if ($_POST['imageId'])
        {
            $query = "
            
            SELECT  likes, like_count
            FROM gallery
            WHERE image_id=:image_id
            ";
            $sql = $pdo->prepare($query);
            $sql->execute(
                array(
                    ':image_id' => $_POST['imageId']
                )
            );
            $count = $sql->rowCount();
            if ($count > 0)
            {
                $result = $sql->fetchAll();
                foreach($result as $row)
                {
                    $like = $row['likes'];
                    $like_nbr=$row['like_count'];

                    if($like !=$_SESSION['user_id'])
                    {
                        $like += 1;
                        $like_nbr=$_SESSION['user_id'];
                    }
                    else 
                    {
                        $like -= 1;
                        $like_nbr= -1;
                    }
                    $query = "
                        UPDATE gallery SET likes=:likes, like_count=:like_count WHERE image_id=:image_id;
                    ";
                    $sql = $pdo->prepare($query);
                    $sql->execute(
                        array(
                            ':likes'      => $like,
                            ':like_count' =>$like_nbr,
                            ':image_id'   => $_POST['imageId']
                        )
                    );
                }
            }
        }
    }
    else
    {
        $arr = ["error" => "You need to sign in or sign up to proceed."];
        echo json_encode($arr);
    }
    
}
?>
