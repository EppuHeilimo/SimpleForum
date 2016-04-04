<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>

    <body>
	<section>
        <form method="post" action="register.php">
			<label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Type a username"><p>
			<label for="passwd">Password</label>
            <input type="password" id="passwd" name="passwd" placeholder="Type a password"><p>
			<label for="passwd2">Retype password</label>
            <input type="password" id="passwd2" name="passwd2" placeholder="Retype password"><p>
            	
            	
            <input type="submit" name="submit" value="Register"><p>

        </form>
        <?php foreach ($warnings as $warning): ?>
            <div class="warning"><?php echo $warning ?></div>
        <?php endforeach; ?>
    </section>
	</body>
</html>