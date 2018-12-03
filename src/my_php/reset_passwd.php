<?php

require_once  '../class/mysql.class.php';

$title = 'Reset_passwd';

if (isset($_POST['submit']))
{
    if (isset($_POST['email']))
    {

        $values = [
            'email' => htmlspecialchars($_POST['email']),
        ];

        $error = [];

        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL) || empty($values['email'])){
            $error['email'] = "Invalid email!";
        }

        $pdo = myPDO::getInstance();
        $query = "
            SELECT user_id, email, username, firstname FROM users
            WHERE email=:user_email
        ";
        $sql = $pdo->prepare($query);
        $sql->execute(
            array(
              ':user_email' => htmlspecialchars($values['email'])
            )
        );
        $count = $sql->rowCount();
        if ($count > 0)
        {
            $user_reset_passwd_code = md5(rand());
            $result = $sql->fetchAll();
            foreach ($result as $row)
            {
                $email = $row['email'];
                $login = $row['username'];
                $firstname = $row['firstname'];
                $dest = $email;
                $sql = $pdo->prepare("UPDATE users SET user_reset_passwd_code=:user_reset_passwd_code WHERE username=:username");
                $sql->bindParam(':user_reset_passwd_code', $user_reset_passwd_code);
                $sql->bindParam(':username', $login);
                $sql->execute();
                $sujet = "Reset Your Password" ;
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: Camagru" ;
                $message =" 
                <div class='row'>
                    <div class='container'>
                        <p>Hi <strong>$firstname</strong>!</p>
                        <p>We got a request to reset your Camagru password.</p>
                        <p>Please click on the button bellow to change your password.</p>
                        <a href='http://localhost:8080/camagru/src/my_php/confirm_passwd.php?log=".urlencode($login)."&key=".urlencode($user_reset_passwd_code)."'>
                        <button type='button' style='color:white;background-color:#3B5998;padding:10px;cursor:pointer;border-radius:5px;'>Reset Password</button></a>
                        <hr>
                        <p>If you ignore this message, your password will not be changed.. </p>
                    </div>
                </div>";             
                 
                mail($dest, $sujet, $message, $headers) ;
                ?>
                <div class="alert alert-success">
                    <a class="close" aria-label="close">&times;</a>
                    <p>Please, verify your email for reset the password!</p>
                </div>
                <?php
            }
        }
        else
            $error['email'] = "Email not exist!";
        }
    if ($error)
    {?>
        <div class="alert alert-danger">
        <a class="close" aria-label="close">&times;</a>
        <?php 
            foreach($error as $value)
                echo "Error: " . $value . "<br>";
        ?>
        </div>
    <?php
    }
}

require_once 'my_header.php';
?>
<section class="section reset">
<div class="row">
    <div class="container">
        <div class="forgot_form">
            <div class="row divform">
            <form  method="POST" id="reset_form">
                <h3 style="color:#3B5998"> Please enter your email address to reset your password</h3>
                <input type="email" name="email" value="" placeholder="Your email" required>
                <button style="border-radius:5px; width:1%;" type="submit" name="submit" value="OK">Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>
</section>
<?php 
    require_once 'my_footer.php';
?>