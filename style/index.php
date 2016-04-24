
<!DOCTYPE html>

<html lang="en">
	<head>
            <title>Simple Forum Template</title>
            <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
            <link rel="stylesheet" type="text/css" href="style/mycss.css">
	</head>
	<body>
            <?php
                require __DIR__ . '/header.php';
            ?>
            <div class='boards'>
                <table border="1">
                    <tr>
                        <td><h3>Board</h3></td>
                        <td><h3>Description</h3></td>
                    </tr>
                    <tr>
                        <?php
                            $db = new DataBase();
                            $boards = $db->getBoards();
                            $count = count($boards);
                            $boardname = 'BoardName';
                            $boarddesc = 'BoardDescription';
                            foreach($boards as $board)
                            {
                                echo "<tr>";
                                echo "<td><form action='Board.php' method='get'><input type='submit' name='boardname' value='$board[$boardname]'> </form></td> <td>$board[$boarddesc]</td>";
                                echo "</tr>";
                            }   
                        ?>
                    </tr>
                </table>
                <?php
                    if(isset($user))
                    {
                       if ($user->isLoggedIn())
                        {
                            if($db->isAdmin($user->getUsername()))
                            {
                                require __DIR__ . '/newboard.php';
                            }
                        }
                    }
                ?>
            </div>
	</body>

</html>



