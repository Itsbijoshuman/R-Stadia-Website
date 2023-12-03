<?php
session_start();
$user_id = $_SESSION['user_id'];
if(isset($_GET['remove']))
{
  $id=$_GET['remove'];
  $conn = new mysqli('localhost','root','','registration');
  $remove_checkout = mysqli_query($conn, "DELETE FROM checkout WHERE user_id=$id; ");
  header('Location:Games1.php');
}
?>


<html>
  <head>
    <link rel="stylesheet" href="payment.css">
    </head>
<div class="wrapper">
  <div class="payment">
    <div class="payment-logo">
      <p>R-S</p>
    </div>
    <h2>Payment Gateway</h2>
    <?php
        $conn = new mysqli('localhost','root','','registration');
        $select_user = mysqli_query($conn,"select * from checkout where user_id='$user_id'");
        if(mysqli_num_rows($select_user) > 0) {
          $fetch_user = mysqli_fetch_assoc($select_user);
      ?>
    <h2>Amount : RS <?php echo $fetch_user['total'];?></h2>
    <?php } ?>
    <div class="form">
      <div class="card space icon-relative">
        <label class="label">Card holder:</label>
        <input type="text" class="input" placeholder="Name On Card">
        <i class="fas fa-user"></i>
      </div>
      <div class="card space icon-relative">
        <label class="label">Card number:</label>
        <input type="text" class="input" data-mask="0000 0000 0000 0000" placeholder="Card Number">
        <i class="far fa-credit-card"></i>
      </div>
      <div class="card-grp space">
        <div class="card-item icon-relative">
          <label class="label">Expiry date:</label>
          <input type="text" name="expiry-data" class="input"  placeholder="00 / 00">
          <i class="far fa-calendar-alt"></i>
        </div>
        <div class="card-item icon-relative">
          <label class="label">CVC:</label>
          <input type="text" class="input" data-mask="000" placeholder="000">
          <i class="fas fa-lock"></i>
        </div>
      </div>
        

      <a href="payment.php?remove=<?php echo $fetch_user['user_id']; ?>" class="btn">PAY</a>

      
    </div>
  </div>
</div>
<html>