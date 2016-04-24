
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login - SimpleForum</title>
        <link rel="stylesheet" type="text/css" href="style/mycss.css">
			
    </head>
    <body>
	<section>
        <div class="login" align="center">
            <h3>Login</h3>
            <form class="login" method="post" action="login.php">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" placeholder="Type a username"><p>
                <label for="passwd">Password: </label>
                <input type="password" id="passwd" name="passwd" placeholder="Type a password"><p>
                <input type="submit" name="login" value="Login"><p>
            </form>
        </div>
        <div class="register" align="center">
            <h3>Register</h3>
            <form class="register" method="post" action="login.php">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" placeholder="Type a username"><p>
                <label for="email">Email: </label>
                <input type="text" id="email" name="email" placeholder="Type your email"><p>
                <label for="passwd">Password: </label>
                <input type="password" id="passwd" name="passwd" placeholder="Type a password"><p>
                <label for="passwd2">Retype password: </label>
                <input type="password" id="passwd2" name="passwd2" placeholder="Retype password"><p>            	
                <input type="submit" name="register" value="Register"><p>
            </form>
        </div>
        <?php foreach ($warnings as $warning): ?>
            <div class="warning"><?php echo $warning ?></div>
        <?php endforeach; ?>
        <?php foreach ($messages as $message): ?>
            <div class="message"><?php echo $message ?></div>
        <?php endforeach; ?>
	</section>
    </body>
</html>




 

