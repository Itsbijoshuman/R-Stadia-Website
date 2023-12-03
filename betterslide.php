<html>
<head>

  <title>CodePen - Carousel with drag and wheel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Roboto'><link rel="stylesheet" href="./css/betterslide.css">

</head>
<body>
<?php

$conn = new mysqli('localhost','root','','registration');
$select_games = mysqli_query($conn,"SELECT * from games") or die('query failed');
if(mysqli_num_rows($select_games)>0)
{
  while($fetch_game = mysqli_fetch_assoc($select_games))
{
?>
<div class="carousel">
	<div class="carousel-item">
		<button type="submit" value="addtocart" data-id="<?php echo $fetch_game['id'] ?>" name="addtocart" class="btn btn-primary">ADD TO CART</button>
		<div class="carousel-box">
			<div class="title"><?php echo $fetch_game['name'] ?></div>
			<div class="num"><?php echo $fetch_game['id'] ?></div>
			<img src="<?php echo $fetch_game['image'] ?>" />
		</div>
	</div>
<?php
        };
      };
?>
  <script  src="./js/betterslide.js"></script>
</body>
</html>

