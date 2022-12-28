<?php
session_start();
echo '<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #002045;">
<div class="container-fluid">
  <a class="navbar-brand" href="index.php" style="font-family: \'Serif\';">iForum</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" color: #FFFFFF;">
            Top categories
          </a>
          <ul class="dropdown-menu">';
          
          $sql = "SELECT category_name,category_id FROM `categories` LIMIT 3";
          $result = mysqli_query($conn,$sql);
          while($row=mysqli_fetch_assoc($result)){
            echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
          }    
 
          echo '</ul>
        </li>
      <li class="nav-item">
      <a class="nav-link" href="contact.php" style=" color: #FFFFFF;">Contact</a>
    </li>
    </ul>';
    $em = $_SESSION['useremail'];
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  echo '<form action="search.php" method="get" class="d-flex mx-2" role="search">
  <div class="container">
  <input class="form-control" name="query" id="search" type="search" placeholder="Search" aria-label="Search">
  </div>
  <button class="btn btn-outline-secondary" type="submit">Search</button>
  <img class="mx-2" src="image/dark_user.jpeg" width="44px" alt="..."> 
  <p class="text-light text-capitalize"  style="margin-right: 10px;">'.strstr($em,"@",true).'</p>
  <a href="partials/_logout.php" class="btn btn-outline-secondary" style="color:#ADD8E6;" type="submit">Logout</a>
   </form>
   </div>';
    }
    else{
      echo '<form action="search.php" method="get" class="d-flex" role="search">
    <div class="container">
    <input class="form-control" name="query" id="search" type="search" placeholder="Search" aria-label="Search">
    </div>
    <button class="btn btn-outline-secondary" type="submit">Search</button>
     </form>
  </div>
<button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>
  <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>';
    }
 echo ' 
</div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success! </strong> You can now login to your account
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>'; 
}
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
  $showError=$_GET['error'];
  echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  <strong>Error! </strong> '.$showError.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

if(isset($_GET['login']) && $_GET['login']=="false"){
  $showError=$_GET['error'];
  echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  <strong>Error! </strong> '.$showError.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>