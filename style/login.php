
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login - SimpleForum</title>
		<link rel="stylesheet" type="text/css" href="mycss.css">
			
    </head>
    <body>
	<section>

        <form method="post" action="login.php">
				<label for="username">Username</label>
				<input type="text" id="username" name="username" placeholder="Type a username"><p>
				<label for="passwd">Password</label>
				<input type="password" id="passwd" name="passwd" placeholder="Type a password"><p>
				<input type="submit" name="submit" value="Login"><p>
        </form>
		<?php foreach ($messages as $message): ?>
            <div class="message"><?php echo $message ?></div>
        <?php endforeach; ?>
	</section>
    </body>
</html>




 

