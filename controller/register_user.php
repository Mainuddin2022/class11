<?php
session_start();
include '../database/env.php';




if (isset($_POST['register'])) {

    //*VARIABLE ASSIGN
    $fist_name = $_POST['fName'];
    $last_name = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $enc_password = sha1($password);


    //*VALIDATION RULES
    $errors = [];
    if (empty($fist_name)) {
        $errors['fName_error'] = "Please Enter your First Name";
    }
    if (empty($last_name)) {
        $errors['lName_error'] = "Please Enter your Last Name";
    }
    if (empty($email)) {
        $errors['email_error'] = "Please Enter your Email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors['email_error'] = "Please Enter a validate Email Address";
    }
    if (empty($password)) {
        $errors['password_error'] = "Please Enter your Password";
    }
    if (empty($confirm_password)) {
        $errors['con_password_error'] = "Please Enter your Confirm Password";
    } elseif ($password !== $confirm_password) {
        $errors['con_password_error'] = "Confirm password did not match!";
    }

    //*CHECKING FOR ERRORS
    if (count($errors) > 0) {
        //*ERRORS FOUND
        $_SESSION['errors'] = $errors;
        header("location: ../backend/register.php");
    } else {
        //*NO ERRORS FOUND

        $query = "INSERT INTO users(first_name, last_name, email, password) VALUES ('$fist_name', '$last_name', '$email', '$enc_password')";
        $store  = mysqli_query($conn, $query);
        if ($store) {
            $_SESSION['success'] = "You have been successfully Registered!";
            header("location: ../backend/login.php");
        }
    }
}
