<?php
    
    require './includes/common.php';
    
    if(isset($_POST['register'])){
        
        $first_name = mysqli_real_escape_string($con, $_POST['registerFirstName']);
        $last_name = mysqli_real_escape_string($con, $_POST['registerLastName']);
        $email_id = mysqli_real_escape_string($con, $_POST['registerEmailId']);
        $password = mysqli_real_escape_string($con, $_POST['registerPassword']);
        $phone_number = mysqli_real_escape_string($con, $_POST['registerPhoneNumber']);
        
        $options = ['cost' => 12];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);
        
        $userInfoInsertionQuery = "insert into users(user_first_name, user_last_name, user_email_id, user_password, user_phone_number) values('$first_name', '$last_name', '$email_id', '$password', '$phone_number')";
        $userInfoInsertionQueryResult = mysqli_query($con, $userInfoInsertionQuery) or die(mysqli_errno($con));
        
        $_SESSION['userFirstName'] = $first_name;
        $_SESSION['userLastName'] = $last_name;
        $_SESSION['userEmailId'] = $email_id;
        $_SESSION['userPhoneNumber'] = $phone_number;
        
        $_SESSION['id'] = mysqli_insert_id($con);

        if(isset($_SESSION['id'])){
            echo "<script>alert('User successfully registered'); window.location = 'index'; </script>";
            exit ;
        }

        if(!isset($_SESSION['id'])){
            header('location: index');
            exit ;
        }
    }