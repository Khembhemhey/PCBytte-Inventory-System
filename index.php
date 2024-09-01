<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PCBYTE - Login and Register</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
    <div class="full-page">
        <div class="navbar">
            <div>
                <a href='website.html'>PCBYTE</a>
            </div>
            <nav>
                <ul id='MenuItems'>
                    <li><a href='#'>Home</a></li>
                    <li><a href='#'>About Us</a></li>
                    <li><a href='#'>Contact</a></li>
                    <li><a href="#">Login</li>
                </ul>
            </nav>
        </div>
        <div id='login-form'class='login-page'>
            <div class="form-box">
                <div class='button-box'>
                    <div id='btn'></div>
                    <button type='button'onclick='login()'class='toggle-btn'>Log In</button>
                    <button type='button'onclick='register()'class='toggle-btn'>Register</button>
                </div>

                <form id='login' action='login.php' class='input-group-login' method="POST">
                    <input type='text' class='input-field' placeholder='Enter Username' name="username" required>
                    <input type='password' class='input-field' placeholder='Enter Password' name="password" required>
                    <div class='remember-me'>
                        <input type='checkbox' class='check-box' id='remember' name='remember'>
                        <label for='remember'>Remember Password</label>
                    </div>
                    <button type='submit' class='submit-btn'>Log in</button>
                </form>

                    
               <!--  <form id='login' action = 'login.php' class='input-group-login' method="POST">
                    <input type='text'class='input-field'placeholder='Enter Username' name="username" required >
                    <input type='password'class='input-field'placeholder='Enter Password' name="password" required>
                    <input type='checkbox'class='check-box'><span>Remember Password</span>
                    <input type='checkbox' class='check-box' id='remember' name='remember'>
                    <label for='remember'>Remember Password</label>
                    <button type='submit'class='submit-btn'>Log in</button>
		        </form> -->
                <form id='register' action="create_account.php" class='input-group-register' method="POST">
                <input type='text' class='input-field' placeholder='Enter Username' name="username" required>
                <input type='password' class='input-field' placeholder='Enter Password' name="password" required>

                <div class='terms'>
                    <input type='checkbox' class='check-box' id='agree' name='agree' required>
                    <label for='agree'>I agree to the <a href='#'>terms and conditions</a>.</label>
                </div>

                <button type='submit' class='submit-btn'>Register</button>
            </form>

            </div>
        </div>
    </div>
    <script>
        var x=document.getElementById('login');
		var y=document.getElementById('register');
		var z=document.getElementById('btn');
		function register()
		{
			x.style.left='-400px';
			y.style.left='50px';
			z.style.left='110px';
		}
		function login()
		{
			x.style.left='50px';
			y.style.left='450px';
			z.style.left='0px';
		}
	</script>
</body>
</html>