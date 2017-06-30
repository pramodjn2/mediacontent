<?php 
$this->load->view('common/header');
?>

<div class="jumbotron">
  <div class="container text-center">
    <h1>My Portfolio</h1>      
    <p>Some text that represents "Me"...</p>
  </div>
</div>
  
<div class="container-fluid bg-3 text-center">    
  <h3>Some of my Work</h3><br>
  <div class="row">
    <div class="col-sm-3">
      <p>Some text..</p>
      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-3"> 
      <p>Some text..</p>
      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-3"> 
      <p>Some text..</p>
      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-3">
      <p>Some text..</p>
      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
    </div>
  </div>
</div><br>

<?php
if(!empty($authUrl)) {
    echo '<a href="'.$authUrl.'"><img src="'.base_url().'assets/images/glogin.png" alt="Glogin"/></a>';
	echo '<a href="'.$fbauthUrl.'"><img src="'.base_url().'assets/images/flogin.png" alt="Facebook"/></a>';
	echo '<a href="'.$linkedinoauthURL.'"><img src="'.base_url().'assets/images/sign-in-with-linkedin.png" alt="Linkedin" /></a>';
	echo '<a href="'.$oauthURL.'"><img src="'.base_url().'assets/images/sign-in-with-twitter.png" alt="Twitter"/></a>';
}else{

?>
<div class="wrapper">
    <h1>Profile Details </h1>
    <?php
    echo '<div class="welcome_txt">Welcome <b>'.$userData['first_name'].'</b></div>';
    echo '<div class="google_box">';
    echo '<p class="image"><img src="'.$userData['picture_url'].'" alt="" width="300" height="220"/></p>';
    echo '<p><b>ID : </b>' . $userData['oauth_uid'].'</p>';
    echo '<p><b>Name : </b>' . $userData['first_name'].' '.$userData['last_name'].'</p>';
    echo '<p><b>Email : </b>' . $userData['email'].'</p>';
    echo '<p><b>Gender : </b>' . $userData['gender'].'</p>';
    echo '<p><b>Locale : </b>' . $userData['locale'].'</p>';
    echo '<p><b>Profile Link : </b>' . $userData['profile_url'].'</p>';
    echo '<p><b>You are login with : </b>' . $userData['oauth_provider'].'</p>';
    echo '<p><b>Logout from <a href="'.base_url().'user_authentication/logout">logout</a></b></p>';
    echo '</div>';
    ?>
</div>
<?php } ?>

<?php 
$this->load->view('common/footer');
?>