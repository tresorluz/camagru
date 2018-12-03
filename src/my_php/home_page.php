<?php
require_once  '../class/mysql.class.php';
require_once  '../include/session_start.php';

$title = 'home_page';
$js_source = ['../javascript/my_webcam.js', '../javascript/save_and_cancel.js', '../javascript/delete_image.js'];

if (isset($_SESSION['user_id']))
{

 
?>
<section class= "container_page">

<div class="usearea_container">
  <div class="image_publish">
    <div class="row">
      <img  src="" id="photo" alt="photo">
    </div>
    <div class="row buttons-row">
      <div class="buttons col-md-12">
        <button type="submit" id="publishbutton" class="col-md-6  btn-success" onclick="save_to_gallery()">Save</button>
        <button type="submit" id="deletebutton" class="col-md-6  btn-danger" onclick="cancel_picture()">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
<div class="col-md-6 ">
<div class="row">
    <h2 align="center" style="color:#3B5998;">Webcam</h2>
    <div class="div_take_photo"> 
      <video id="video"></video>
      <canvas id="canvas"></canvas>
      <div class="buttons col-md-12">
        <button type="submit" id="startbutton" class="col-md-6 btn-primary"><i class="fa fa-camera-retro"></i></button>
        <div id="upload_photo" class="col-md-6 btn-primary label-file">
        <center><label for="file"><br><i class="fa fa-upload"></i></label></center>
        <input type="file" class="input-file" name="pic" accept="image/png" id='file' src="" onchange="picture_to_url(this)" onclick="this.value=null;">
        </div>
      </div>
    </div>
  </div>
<div class="row filters">
  <h3 class="center" style="color: #3B5998">Select a Sticker</h3>
    <form class="form-horizontal " role="form">
      <div class="row" >
        <div class="col-md-3 col-xs-6">
          <img style="i" src="../resources/images/flower.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio active" onclick="select_sticker(this.id)" id="1">Flower</button>
          <input type="checkbox" name="src"  class="hidden">
        </div> 
        <div class="col-md-3 col-xs-6">
          <img src="../resources/images/golden_stars.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_sticker(this.id)" id="2">Stars</button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img src="../resources/images/golden.png" class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_sticker(this.id)" id="3">Golden Frame</button>
          <input type="checkbox" name="src" class="hidden">
        </div>
        <div class="col-md-3 col-xs-6">
          <img style= "visibility:hidden" src="#"  class="img-responsive img-radio" draggable="false">
          <button type="button" class="btn btn-primary btn-radio" onclick="select_sticker(this.id)" id="4">without frame</button>
          <input type="checkbox" name="src" id="4" class="hidden">
        </div>  
      </div>
    </form>
  </div>
</div>

   
    <div class="col-md-6 last_photos">
    <h2 align="center" style="color:#3B5998;">Pictures</h2>
<?php
  $query = '
    SELECT image_url, image_id
  FROM users
  INNER JOIN gallery ON users.user_id = gallery.user_id
  WHERE gallery.user_id=:user_id
  ORDER BY gallery.date_time_photo DESC
  LIMIT 16';

  $query = $pdo->prepare($query);
  $query->execute(
    array(
      ':user_id' => $_SESSION['user_id']
    )

  );
  $count = $query->rowCount();
 
  if ($count > 0)
  {
    $result = $query->fetchAll();
      foreach ($result as $row)
      {
        ?>
        <div class="col-md-3 col-xs-6"> 
          <a target="_self" href="<?php echo $row['image_url']?>">
         <img src="<?php echo $row['image_url']?>" alt="pic"></a>
          <button class="delete_last_photo" onclick="delete_image(<?php echo  $row['image_id'];?>)">Delete</button>
        </div>
     
        <?php
      }

    
  }
    ?>
  </div>
  </div>
</section>
<div class="my_header">
<?php
echo '<div id="alert"></div>';
  require_once 'my_header.php';
?>
</div>
<?php
require_once 'my_footer.php';
}
else
  header ('location: login_form.php');
?>
