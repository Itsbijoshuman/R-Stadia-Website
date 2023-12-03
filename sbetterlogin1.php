<!DOCTYPE html>
<html lang="en" >
<head>
  <title>Login/Register</title>
  <link rel="stylesheet" href="./css/betterlogin.css">
</head>

<script>
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
<body>
<span id="username-error" style="color: red;"></span>
	<div id="container" class="container">
		<div class="row">
			<div class="col align-items-center flex-col sign-up">
				<div class="form-wrapper align-items-center">
						<form method="post">
						<div class="form sign-up">
						<div class="input-group">
							<i class='bx bxs-user'></i>
							<input type="text" placeholder="Name" required name="name">
						</div>
						<div class="input-group">

							<i class='bx bxs-user'></i>
							<input type="text" placeholder="Username" required name="username">

						</div>
						<div class="input-group">

							<i class='bx bx-mail-send'></i>
							<input type="email" placeholder="Email" required name="email">

						</div>

						<div class="input-group">

							<i class='bx bx-mail-send'></i>
							<input type="text" placeholder="Phone" required name="phone">

						</div>
						<div class="input-group">

							<i class='bx bxs-lock-alt'></i>
							<input type="password" placeholder="Password" required name="password" id="password">

						</div>
						<div class="input-group">
							<i class='bx bxs-lock-alt'></i>

							<input type="password" placeholder="Confirm password" required name="confirmpassword" id="confirm-password" onkeyup="checkPassword()";>
							<span id="password-error" style="color: red;"></span>

						</div>
							<div class="gender-details">
							<input type="radio" name="type" id="dot-1" value="h">
							<input type="radio" name="type" id="dot-2" value="o">
							<input type="radio" name="type" id="dot-3" value="c">

							<span class="gender-title">Type Of Account</span>
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
						<!-- <div class="button">
							<input name="submit" type="submit" value="Register" id="register-button" disabled> 
						</div> -->
						<button name="submit" type="submit" value="Register" id="register-button" disabled>Submit</button>
						<p>
							<span>
								Already have an account?
							</span>
							<b onclick="toggle()" class="pointer">
								Sign in here
							</b>
						</p>
					</form>
					</div>
				</div>
			</div>
            		<div class="row content-row">
			<div class="col align-items-center flex-col">
				<div class="text sign-in">
					<h2>
					WELCOME TO R-STADIA
					</h2>
				</div>
				<div class="img sign-in">
				</div>
			</div>
			<div class="col align-items-center flex-col">
				<div class="img sign-up">
				</div>
				<div class="text sign-up">
					<h2>
						JOIN US
					</h2>
				</div>
			</div>
		</div>
	</div>
	<script  src="./js/betterlogin.js"></script>
</body>
</html>