<?php 
echo "<form action='index.php'><input type='submit' name='toindex' value='Index'></form>";
//TODO: add button to go back to board if in thread
?>
<div class='myheader'> 
<?php
    
    if(isset($user))
    {
       if ($user->isLoggedIn())
        {
           echo "<h3> Logged in as {$user->getUsername()} </h3><form action='logout.php'><input type='submit' name='logout' value='Logout'></form>";
        }
    }
    else 
    {
        echo "<h3>Not logged in.</h3> <form action='login.php'><input type='submit' name='login' value='Login'></form>";
    }
?>
</div>
<h1> Forum </h1>
