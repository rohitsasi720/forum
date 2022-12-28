<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST"){
 include '_dbconnect.php';
 $email = $_POST['signupEmail'];
 $pass = $_POST['password'];
 $cpass = $_POST['cpassword'];

 $existsql = "SELECT * FROM `users` WHERE user_email='$email'";
 $result = mysqli_query($conn,$existsql);
 $row = mysqli_num_rows($result);
 
 if($row>0){
    $showError = "Email already exist";
 }
 else{
    if($pass==$cpass && ($email!=NULL && $pass!=NULL)){
        $hash = password_hash($pass,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$email', '$hash', current_timestamp())";
        $result = mysqli_query($conn,$sql);
        if($result){
            $showAlert=true;
            header("Location: /forum/index.php?signupsuccess=true");
            exit();
        }
    }
    else{
        $showError = "Please check your password";
    }
 }
 header("Location: /forum/index.php?signupsuccess=false&error=$showError");
}
?>