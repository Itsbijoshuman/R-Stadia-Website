
<?php
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id))
{
  header('Location:login.php');
}
?>

<html>
<head>
  <title>Timer Page</title>
  <link rel="stylesheet" href="gapps1.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body onload="startTimer()">
  <div class="container">
    <div class="user-profile">
      <?php
        $conn = new mysqli('localhost','root','','registration');
        $select_user = mysqli_query($conn,"select * from all_users where id='$user_id'");
        if(mysqli_num_rows($select_user) > 0) {
          $fetch_user = mysqli_fetch_assoc($select_user);
      ?>
        <p>USERNAME: <span><?php echo $fetch_user['Username'];?></span></p>
        <p>EMAIL: <span><?php echo $fetch_user['Email'];?></span></p>
        <div class="flex">
          <a href="Games1.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to logout?');" class="delete-btn">Logout</a>
        </div>
      <?php } ?>
    </div>

    <div class="timer-section">
      <h1>Timer</h1>
      <div class="timer">00:00:00</div>
      <a name="stop"class="stop-btn">Stop</a>
    </div>

    <div class="shopping-cart">
      <h1>Rented Applications</h1>
      <table>
        <tbody>
          <?php
            $conn = new mysqli('localhost','root','','registration');
            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $grand_total = 0;
            if(mysqli_num_rows($cart_query) > 0) {
              while($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                $price = $fetch_cart['price'];
                $app_id = $fetch_cart['id'];
          ?>
            <tr>
              <td><img src="<?php echo $fetch_cart['image']; ?>" height="100"></td>
              <td><?php echo $fetch_cart['name']; ?></td>
              <td>
                <form method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $app_id; ?>">
                </form>
              </td>
              <td>
                <div class="price" id="price_<?php echo $app_id; ?>">Price: Rs <?php echo number_format($price, 2); ?></div>
              </td>
            </tr>
          <?php
              }
            }
          ?>
        </tbody>
      </table>
      <div class="total-price">
        <form method="post">
      <h1>Total Price To Be Payed</h1>
      <div class="price" name="total_price" id="total_price">0.00</div>
      <div class="flex">
          <a href="payment.php" class="btn btn-primary" id="backtocart" name="backtocart" style="display:none;">Proceed To Pay</a>
        </div>
          </form>  
    </div>
      </div>
    </div>
  </div>

<?php
$conn = new mysqli('localhost', 'root', '', 'registration');
$select_all=mysqli_query($conn, "SELECT * FROM cart");
$temp_id=mysqli_fetch_assoc($select_all);
$id=$temp_id['id'];
$select_app = mysqli_query($conn, "SELECT price FROM cart WHERE id='$id' && user_id='$user_id'");
if(mysqli_num_rows($select_app) > 0) {
  $fetch_app = mysqli_fetch_assoc($select_app);
  $price = $fetch_app['price'];
}
?>



<script>

  document.querySelector('.stop-btn').addEventListener('click', stopTimer);

<?php
  $conn = new mysqli('localhost', 'root', '', 'registration');
  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
  if(mysqli_num_rows($cart_query) > 0) {
    while($fetch_cart = mysqli_fetch_assoc($cart_query)) {
      $price = $fetch_cart['price'];
      $app_id = $fetch_cart['id'];
?>
  let price_<?php echo $app_id; ?> = .0<?php echo $price; ?>;
<?php
    }
  }
?>

let timerId = null;
let startTime = null;

function startTimer() {
  startTime = Date.now();
  timerId = setInterval(() => {
    const elapsedTime = Date.now() - startTime;
    const hours = Math.floor(elapsedTime / 3600000);
    const minutes = Math.floor((elapsedTime % 3600000) / 60000);
    const seconds = Math.floor((elapsedTime % 600000) / 1000);
    const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    document.querySelector('.timer').textContent = formattedTime;

    <?php
      $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($cart_query) > 0) {
        while($fetch_cart = mysqli_fetch_assoc($cart_query)) {
          $price = $fetch_cart['price'];
          $app_id = $fetch_cart['id'];
    ?>
      price_<?php echo $app_id; ?> += .0<?php echo $price; ?>;
      const priceElement_<?php echo $app_id; ?> = document.querySelector('#price_<?php echo $app_id; ?>');
      priceElement_<?php echo $app_id; ?>.textContent = `Price: Rs ${price_<?php echo $app_id; ?>.toFixed(2)}`;
    <?php
        }
      }
    ?>
  }, 1000);
}

function stopTimer() {
  clearInterval(timerId);
  timerId = null;
  console.log('Timer stopped');

  clearInterval(timerId);
  const cartQuery = document.querySelectorAll('.price');
  let totalPrice = 0;
  for (let i = 0; i < cartQuery.length; i++) {
    const priceText = cartQuery[i].textContent;
    const priceValue = parseFloat(priceText.replace('Price: Rs ', ''));
    totalPrice += priceValue;
  }
  const formattedPrice = totalPrice.toFixed(2);
  document.querySelector('#total_price').textContent = formattedPrice;
  document.getElementById('backtocart').style.display = 'block';

  // Send the formatted price to the PHP script for saving to the database
  $.ajax({
    type: "POST",
    url: "saveprice.php",
    data: { formattedPrice: formattedPrice },
    success: function(data) {
      console.log("Formatted price saved to database.");
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error("Error saving formatted price to database: " + errorThrown);
    }
  });
}

</script>
