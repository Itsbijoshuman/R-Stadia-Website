<?php

session_start();
$owner_id = $_SESSION['owner_id'];

if(!isset($owner_id))
{
  header('Location:login.php');
}

if(isset($_GET['logout']))
{
  unset($owner_id);
  session_destroy();
  header('Location:login.php');
}

if(isset($_GET['gremove']))
{

  $conn = new mysqli('localhost','root','','registration');
  $remove_id = $_GET['gremove'];
  mysqli_query($conn, "DELETE FROM `games` WHERE id = '$remove_id'") or die('query failed');

}

if(isset($_GET['aremove']))
{

  $conn = new mysqli('localhost','root','','registration');
  $remove_id = $_GET['aremove'];
  mysqli_query($conn, "DELETE FROM `apps` WHERE id = '$remove_id'") or die('query failed');

}




if(isset($_GET['remove'])){
  $conn = new mysqli('localhost','root','','registration');

  $remove_id = $_GET['remove'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
  header('location:Games1.php');
}
 
if(isset($_GET['delete_all'])){
  $conn = new mysqli('localhost','root','','registration');

  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$owner_id'") or die('query failed');
  header('location:Games1.php');
}




if(isset($_POST['submit']))
{
  $name = $_POST['name'];
  $price = $_POST['price'];
  $img = $_POST['img'];
  $des = $_POST['des'];
  $type = $_POST['type'];

  $conn = new mysqli('localhost','root','','registration');

  if($conn->connect_error)
  {
    die('Connection Failed : '.$conn->connect_error);
  }
  else
  {
      if($_POST['type'] == 'g')
      {
          $stmt1=$conn->prepare("insert into games(name,price,image,des) values(?,?,?,?)");
          $stmt1->bind_param("siss",$name,$price,$img,$des);
          $stmt1->execute();
          $stmt1->close();
          $conn->close();
          //echo "<script>document.getElementById('username-error').innerHTML = 'Inserted INTO C';</script>";

      }
      else 
      {
        $stmt1=$conn->prepare("insert into apps(name,price,image,des) values(?,?,?,?)");
        $stmt1->bind_param("siss",$name,$price,$img,$des);
        $stmt1->execute();
        $stmt1->close();
        $conn->close();
        }
        //echo "<script>document.getElementById('username-error').innerHTML = 'Inserted INTO H';</script>";
      }
    }
?>

<!DOCTYPE html>
  <head>
    <title>R-STADIA GAME</title>
    <link href="gapps2.css" rel="stylesheet">
  </head>
  <body>

  <!---put nav bar here and slider -->

  <div class = "container">
  <div class="user-profile">

    <?php

   // include 'login.php';

    $conn = new mysqli('localhost','root','','registration');
    $select_user = mysqli_query($conn,"select * from all_users where id='$owner_id'");
    if(mysqli_num_rows($select_user)>0)
    {
      $fetch_user = mysqli_fetch_assoc($select_user);
    }
    ?>

    <p>USERNAME :<span><?php echo $fetch_user['Username'];?></span></p>
    <p>EMAIL    :<span><?php echo $fetch_user['Email'];?></span></p>
    <p>TYPE     : OWNER</p>


    <div class="flex">
      <a href="Games1.php?logout=<?php echo $owner_id; ?>" onclick="return confirm('Are You Sure you want to logout?');" class="delete-btn">logout</a>
  </div>
  </div>

  
<form id = "formElement1" method="post"> 
<div class="regcontainer">
    <div class="title"></div>
    <div class="content">
    <span id="username-error" style="color: red;"></span>
      <form>
        <div class="user-details">
          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" placeholder="Enter Game/App Name" required name="name">
          </div>
          <div class="input-box">
            <span class="details">Price</span>
            <input type="text" placeholder="Enter Price per min" required name="price">
            <span id="username-error" style="color: red;"></span>
          </div>
          <div class="input-box">
            <span class="details">Image link</span>
            <input type="text" placeholder="Paste image link" required name="img">
          </div>
          <div class="input-box">
            <span class="details">Description</span>
            <input type="text" placeholder="Enter Game/App Description" required name="des">
          </div>
          
          
        </div>
        <div class="gender-details">
          <input type="radio" name="type" id="dot-1" value="a">
          <input type="radio" name="type" id="dot-2" value="g">
         
          <span class="gender-title">Choose</span>
          <div class="category">
            <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">APPS&nbsp;</span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">GAMES</span>
          </label>
         
          </div>
        </div>
        
        <div class="button">
          <input name="submit" type="submit" value="ADD TO SERVER" id="register-button"> 
        </div>
      </form>
    </div>
  </div>
  </form>
      <div class="products">
          <h2 class="text-center">LISTED GAMES</h2>
          <div class="box-container">
          
          <?php
              $conn = new mysqli('localhost','root','','registration');
              $select_games = mysqli_query($conn,"SELECT * from games") or die('query failed');
              if(mysqli_num_rows($select_games)>0)
              {
                while($fetch_game = mysqli_fetch_assoc($select_games))
              {
          ?>
                <form method="post" class="box">
                    <img src="<?php echo $fetch_game['image'] ?>">
                    <div class="name"><?php echo $fetch_game['name'] ?></div>
                    <div class="price"><?php echo $fetch_game['price'] ?> ps/ min</div>
                    <div class="name"><?php echo $fetch_game['des'] ?></div>
                    <input type="hidden" name="product_image" value="<?php echo $fetch_game['image'] ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_game['name'] ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_game['price'] ?>">
                    <input type="hidden" name="product_des" value="<?php echo $fetch_game['des'] ?>">
                    <a href="ownerdashboard.php?gremove=<?php echo $fetch_game['id']; ?>" onclick="return confirm('Are You Sure you want to Remove ?');" class="delete-btn">Remove</a>
                </form>
      <?php
              };
            };
      ?>

        </div>
        </div>


        <div class="products">
          <h2 class="text-center">LISTED APPS</h2>
          <div class="box-container">
          
          <?php
              $conn = new mysqli('localhost','root','','registration');
              $select_games = mysqli_query($conn,"SELECT * from apps") or die('query failed');
              if(mysqli_num_rows($select_games)>0)
              {
                while($fetch_game = mysqli_fetch_assoc($select_games))
              {
          ?>

                <form method="post" class="box">
                    <img src="<?php echo $fetch_game['image'] ?>">
                    <div class="name"><?php echo $fetch_game['name'] ?></div>
                    <div class="price"><?php echo $fetch_game['price'] ?> ps/ min</div>
                    <div class="name"><?php echo $fetch_game['des'] ?></div>
                    <input type="hidden" name="product_image" value="<?php echo $fetch_game['image'] ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_game['name'] ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_game['price'] ?>">
                    <input type="hidden" name="product_des" value="<?php echo $fetch_game['des'] ?>">
                    <a href="ownerdashboard.php?aremove=<?php echo $fetch_game['id']; ?>" onclick="return confirm('Are You Sure you want to Remove ?');" class="delete-btn">Remove</a>
                </form>
      <?php
              };
            };
      ?>

        </div>
        </div>

</div>

  

  </body>
</html>