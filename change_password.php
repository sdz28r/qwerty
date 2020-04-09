<?php

    require 'includes/common.php';
    
    if(isset($_POST['confirm'])){
        $oldPassword = mysqli_real_escape_string($con, $_POST['oldPassword']);

        $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);
        $password = $newPassword;
        
        $options = ['cost' => 12];
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT, $options);
         
        $confirmNewPassword = mysqli_real_escape_string($con, $_POST['confirmNewPassword']);
        $passwordVerify = password_verify($oldPassword, $newPassword);
        
        $email = $_SESSION['userEmailId'];
        
        $passwordSelectionQuery = "select user_password from users where user_email_id = '$email'";
        $passwordSelectionQueryResult = mysqli_query($con, $passwordSelectionQuery) or die(mysqli_errno($con));
        $resultArray = mysqli_fetch_array($passwordSelectionQueryResult);
        if(password_verify($oldPassword, $resultArray[0])){
            if(password_verify($confirmNewPassword, $newPassword)){
                if(strlen($password) >= 6){
                    if(!$passwordVerify){
                        $passwordUpdationQuery = "update users set user_password = '$newPassword' where user_email_id = '$email'";
                        $passwordUpdationQueryResult = mysqli_query($con, $passwordUpdationQuery) or die(mysqli_errno($con));
                        if(isset($_SESSION['id'])){
                            echo "<script>alert('Password successfully changed, you have been logged out, please login again.');"
                            . "window.location = 'logout'; </script>";
                            exit ;
                        }
                    }
                    else{
                        echo "<script>alert('New Password cannot be same as the old password.');"
                        . "window.location = 'home'; </script>";
                    }
                }
                else{
                    echo "<script>alert('New Password too short.');"
                    . "window.location = 'home'; </script>";
                }
            }
            else{    
                echo "<script>alert('Passwords do not match.');"
                . "window.location = 'home'; </script>";
            }
        }
        else{        
            echo "<script>alert('Wrong password!!!');"
            . "window.location = 'home'; </script>";
        }
    } else{
        echo "<script>alert('Fatal Error!!!');"
            . "window.location = 'home'; </script>";
    }