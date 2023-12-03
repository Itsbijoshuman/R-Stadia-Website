<?php
        if(isset($_POST['submit']))
        {
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
              if($_POST['type'] == 'c')
              {
                $query = "SELECT * FROM customer WHERE username='$username'";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) 
                {
                  echo "<script>document.getElementById('username-error').innerHTML = 'Username is already taken';</script>";
                }
                else
                {
                  $stmt1=$conn->prepare("insert into all_users(Name,Username,Email,Password,Phone,type) values(?,?,?,?,?,?)");
                  $stmt1->bind_param("ssssis",$name,$username,$email,$password,$phone,$type);
                  $stmt1->execute();
                  $stmt1->close();
                  $stmt = $conn->prepare("insert into customer(Name,Username,Email,Phone,Password) values (?,?,?,?,?)");
                  $stmt->bind_param("sssis",$name,$username,$email,$phone,$password);

                  $stmt->execute();
                  $stmt->close();
                  

                  $stmt2=$conn->prepare("UPDATE all_users t1, customer t2 SET t2.id = t1.id WHERE t1.username = t2.username;");
                  $stmt2->execute();
                  $stmt2->close();
                  $conn->close();
                }
              }
              else if ($_POST['type'] == "o")
              {
                $query = "SELECT * FROM owner WHERE username='$username'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) 
                {
                  echo "<script>document.getElementById('username-error').innerHTML = 'Username is already taken';</script>";
                } 
                else
                {
                  $stmt1=$conn->prepare("insert into all_users(Name,Username,Email,Password,Phone,type) values(?,?,?,?,?,?)");
                  $stmt1->bind_param("ssssis",$name,$username,$email,$password,$phone,$type);
                  $stmt = $conn->prepare("insert into owner(Name,Username,Email,Phone,Password) values (?,?,?,?,?)");
                  $stmt->bind_param("sssis",$name,$username,$email,$phone,$password);

                  $stmt1->execute();
                  $stmt->execute();

                  $stmt1->close();
                  $stmt->close();

                  $stmt2=$conn->prepare("UPDATE all_users t1, owner t2 SET t2.id = t1.id WHERE t1.username = t2.username;");
                  $stmt2->execute();
                  $stmt2->close();
                  $conn->close();
                }
              }
              else 
              {
                $query = "SELECT * FROM host WHERE username='$username'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) 
                {
                  echo "<script>document.getElementById('username-error').innerHTML = 'Username is already taken';</script>";
                } 
                else
                {
                $stmt1=$conn->prepare("insert into all_users(Name,Username,Email,Password,Phone,type) values(?,?,?,?,?,?)");
                $stmt1->bind_param("ssssis",$name,$username,$email,$password,$phone,$type);
                $stmt = $conn->prepare("insert into host(Name,Username,Email,Phone,Password) values (?,?,?,?,?)");
                $stmt->bind_param("sssis",$name,$username,$email,$phone,$password);

                  $stmt1->execute();
                  $stmt->execute();

                $stmt1->close();
                $stmt->close();

                $stmt2=$conn->prepare("UPDATE all_users t1, host t2 SET t2.id = t1.id WHERE t1.username = t2.username;");
                $stmt2->execute();
                $stmt2->close();
                $conn->close();
                }
              }
            }
    }
?>
<?php
session_start();
if(isset($_POST['login'])) 
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $conn = new mysqli('localhost','root','','registration');


  $username = mysqli_real_escape_string($conn, $username);
  $password = mysqli_real_escape_string($conn, $password);


  $stmt = $conn->prepare("SELECT * FROM customer WHERE username=? and password=?");
  $stmt->bind_param("ss", $username,$password);
  $stmt->execute();
  $result = $stmt->get_result();

  if(mysqli_num_rows($result) > 0) 
  {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['id'];
    header("Location:Games1.php");
  }
  else
  {
    echo "<script>document.getElementById('username-error').innerHTML = 'Username/Password is Incorrect';</script>";
  }
  $stmt->close();
  mysqli_free_result($result); // free up result set before executing the next query

  $stmt1 = $conn->prepare("SELECT * FROM owner WHERE username=? and password=?");
  $stmt1->bind_param("ss", $username,$password);
  $stmt1->execute();
  $result1 = $stmt1->get_result();

  if(mysqli_num_rows($result1) > 0) 
  {
    $row = mysqli_fetch_assoc($result1);
    $_SESSION['owner_id'] = $row['id'];
    header("Location:ownerdashboard.php");
  }
  else
  {
    echo "<script>document.getElementById('username-error').innerHTML = 'Username/Password is Incorrect';</script>";
  }
  $stmt1->close();
  mysqli_free_result($result1);

  $stmt2 = $conn->prepare("SELECT * FROM host WHERE username=? and password=?");
  $stmt2->bind_param("ss", $username,$password);
  $stmt2->execute();
  $result2 = $stmt2->get_result();

  if(mysqli_num_rows($result2) > 0) 
  {
    $row = mysqli_fetch_assoc($result2);
    $_SESSION['host_id'] = $row['id'];
    header("Location:hostdashboard.php");
  }
  else
  {
    echo "<script>document.getElementById('username-error').innerHTML = 'Username/Password is Incorrect';</script>";
  }
  $stmt2->close();
  mysqli_free_result($result2);
  $conn->close(); 
}

?>


<html>
    <head>
        <link href="css/loginpage.css" rel="stylesheet">
       
        <meta charset="UTF-8">
  <title>Login R-stadia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'><link rel="stylesheet" href="">
    </head>
    <body>

   

    
  <div class="better">
  <div class="container-fluid">
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li><a id="len1" class="hoverable" href="home1.html">Home</a></li>
        <li><a id="len2" class="hoverable" href="#">App</a></li>
        <li><a id="len3" class="hoverable" href="#">Games</a></li>
      </ul>
       </div>
 </nav>
</div>
</div>



    
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./js/betternav.js"></script> 
    <script type="text/javascript">

    function showForm() 
        {
            document.getElementById('formElement').style.display = 'block';
        }
      
  function showForm1()
      {
        document.getElementById('formElement1').style.display='block';
      }
  function hideForm()
      {
        document.getElementById("formElement").style.display="none";
      }
  function hideForm1()
      {
        document.getElementById("formElement1").style.display="none";
      }

      function checkPassword() 
      {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm-password');
        const passwordError = document.getElementById('password-error');
        const registerButton = document.getElementById("register-button");

        if (password.value !== confirmPassword.value) 
        {
          passwordError.innerHTML = 'Passwords do not match';
          registerButton.disabled = true;
        } 
        else 
        {
          registerButton.disabled = false;
          passwordError.innerHTML = '';
        }
    }

    </script>



    
       <div class = "login-form1">
     <button id = "button1" onclick="showForm();hideForm1()">LOGIN</button>
       </div>
    <div class="login-form2">
    <button id = "button2" onclick="hideForm();showForm1()">SIGN UP</button>
  </div>
      <form id="formElement" style="display:none;" method="post">
     
      <div class="login-page">
          <div class="form">
            <form class="login-form" method="post">
              <input type="text" name="username" placeholder="username" required />
              <input type="password" name="password" placeholder="password" required/>
              <button type="submit" name="login">login</button>
              <div id="error-message"></div>
              <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
                
          </div>
        </div>
      </form> 

      
      


<script type = "text/javascript">
var body = document.querySelector('body');
var button= document.querySelector('button');
button1.addEventListener('click', function () {
  body.classList.toggle('alt');
});

button2.addEventListener('click', function () 
{
  body.classList.toggle('alt');});


        </script>
        
        
          
 
 
 
<form id = "formElement1" style = "display:block;" action="" method="post"> 
<div class="regcontainer">
    <div class="title"></div>
    <div class="content">
      <form>
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" placeholder="Enter your name" required name="name">
          </div>
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" placeholder="Enter your username" required name="username">
            <span id="username-error" style="color: red;"></span>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" placeholder="Enter your email" required name="email">
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" placeholder="Enter your number" required name="phone">
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" placeholder="Enter your password" required name="password" id="password">
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" placeholder="Confirm your password" required name="confirmpassword" id="confirm-password" onkeyup="checkPassword();">
            <span id="password-error" style="color: red;"></span>
          </div>
        </div>
        <div class="gender-details">
          <input type="radio" name="type" id="dot-1" value="h">
          <input type="radio" name="type" id="dot-2" value="o">
          <input type="radio" name="type" id="dot-3" value="c">
          <span class="gender-title">Type Of Account&nbsp;</span>
          <div class="category">
            <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Host&nbsp;</span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">Owner</span>
          </label>
          <label for="dot-3">
            <span class="dot three"></span>
            <span class="gender">Customer&nbsp;</span>
            </label>
          </div>
        </div>
        <span id="password_error" style="color: red;"></span>
        <div class="button">
          <input name="submit" type="submit" value="Register" id="register-button" disabled> 
        </div>
      </form>
    </div>
  </div>
  </form>
 
  </div>
        <div class="pic3">
          <img src = "https://images2.imgbox.com/cb/db/RjXNU1UW_o.png" height="60px" weight="60px">
          </div>
          <div class="pic4">
            <img src = "https://images2.imgbox.com/29/f0/OItAVNO8_o.png" height="100px" weight="100px">
            </div>
  </body>
  </html>
  