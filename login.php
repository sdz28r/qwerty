<?php
    
    require './includes/common.php';
    
    if(isset($_POST['login'])){
        
        $email_id = mysqli_real_escape_string($con, $_POST['loginEmailId']);
        $password = mysqli_real_escape_string($con, $_POST['loginPassword']);
        $pass = $password;
        
        $emailSelectionQuery = "select * from users where user_email_id = '$email_id'";
        $emailSelectionQueryResult = mysqli_query($con, $emailSelectionQuery) or die(mysqli_errno($con));
        $resultArray = mysqli_fetch_array($emailSelectionQueryResult);
        $rows = mysqli_num_rows($emailSelectionQueryResult);
                
        if(password_verify($password, $resultArray['user_password'])){
            $_SESSION['userFirstName'] = $resultArray['user_first_name'];
            $_SESSION['userLastName'] = $resultArray['user_last_name'];
            $_SESSION['userEmailId'] = $resultArray['user_email_id'];
            $_SESSION['userPhoneNumber'] = $resultArray['user_phone_number'];
            $_SESSION['id'] = mysqli_insert_id($con);
            
            if(!empty($_POST["remember"])){
                setcookie ("loginId", $email_id, time()+ (10 * 365 * 24 * 60 * 60));  
                setcookie ("loginPassword", $pass, time()+ (10 * 365 * 24 * 60 * 60));
            }else{
                setcookie ("loginId",""); 
                setcookie ("loginPassword","");
            }
        }

        if(isset($_SESSION['id'])){
            header('location: home');
        } else{
            if($rows < 1){
                echo "<script>alert('User with this email address does not exist'); window.location = 'index'; </script>";
            } else{
                echo "<script>alert('Invalid email address or password'); window.location = 'index'; </script>";
            }
        }
        
    }