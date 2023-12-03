<?php

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $type = $_POST['type'];
    $confirmpassword = $_POST['confirmpassword'];

    $conn = new mysqli('localhost','root','','registration');

        if($conn->connect_error)
        {
            die('Connection Failed : '.$conn->connect_error);
        }
        else
        {
            $stmt = $conn->prepare("insert into users(name,username,email,phone,password,type) 
            values (?,?,?,?,?,?)");
            $stmt->bind_param("sssiss",$name,$username,$email,$phone,$password,$type);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
?>