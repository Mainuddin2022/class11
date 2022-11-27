<?php
session_start();
include '../database/env.php';
if(isset($_POST['submit'])){
   
// Assing Variable
$email= $_POST['email'];
$password= $_POST['password'];
$enc_password = sha1($password);

//Validation Rulse
$errors = [];
if(empty($email)){
    $errors['email']= 'Plase Enter a Email Adress';
}
if(empty($password)){
    $errors['password']= 'Plase Enter a password';
}

//Rediaction
if(count($errors) > 0){
    $_SESSION['errors']= $errors;
    header("location: ../backend/login.php");
}else{
    //NO Errors



    //Email Check
$query= "SELECT * FROM users WHERE email = '$email'";
$data = mysqli_query($conn,$query);
if(mysqli_num_rows($data) > 0){

    //Email Found
   $query= "SELECT * FROM `users` WHERE email='$email' AND password = '$enc_password'";
   $data = mysqli_query($conn,$query);
   if(mysqli_num_rows($data) > 0){
    //Logine To Deshbored

    $auth= mysqli_fetch_all($data);
    $_SESSION['auth']=$auth;

    header("location: ../backend/dashboard.php");

   }
   else{
    //Password Arrors

    $_SESSION['errors']['password']= 'Incorrcet Password!';
    header("location: ../backend/login.php");

   }



}




else{

    //Email Not Found
    $_SESSION['errors']['email']= 'No Email Address Founds!';
    header("location: ../backend/login.php");
}

}




}