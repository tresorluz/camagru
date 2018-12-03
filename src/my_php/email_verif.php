<?php
 require_once  '../class/mysql.class.php';

if (!isset($_GET['log']) || !isset($_GET['key']))
{
    header ('location: registration.php');
}
else
{
    $pdo = myPDO::getInstance();

    $login = htmlspecialchars($_GET['log']);
    $key = htmlspecialchars($_GET['key']);
    $sql = $pdo->prepare("SELECT user_id FROM users WHERE username=:username AND user_activation_code=:user_activation_code AND user_email_status=:user_email_status");
    $sql->execute(
        array(
            ':username'             => $login,
            ':user_activation_code' => $key,
            ':user_email_status'    => 'not verified'
        )
    );
    $sql->execute();
    $count_row = $sql->rowCount();

    if ($count_row > 0)
    {
        $sql = $pdo->prepare("UPDATE users SET user_email_status=:user_email_status, user_activation_code=:user_activation_code WHERE username=:username");
        $sql->execute(
            array(
                ':user_email_status'    => 'verified',
                ':user_activation_code' => '',
                ':username'             => $login
            )
        );

        header('location: login_form.php');
        
    }
    else
    {
        header ('location: ../my_php/registration.php');
    }
}
?>