
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
                        <td><h3>Thread</h3></td>
                        <td><h3>Views</h3></td>
                        <td><h3>Replies</h3></td>
                        <td><h3>Posted</h3></td>
                    </tr>
                    <tr>
                        <?php
                        if(isset($_GET['boardname']))
                        {
                            $db = new DataBase();
                            $threads = $db->getThreads($_GET['boardname']);
                            $count = count($threads);
                            $threadname = 'ThreadName';
                            $views = 'ViewCount';
                            $replies = 'PostCount';
                            $posted = 'CreateDate';
                            foreach($threads as $thread)
                            {
                                echo "<tr>";
                                echo "<td><form action='Thread.php' method='get'><input type='submit' name='threadname' value='$thread[$threadname]'> </form></td>";
                                echo "<td>$thread[$views]</td>";
                                echo "<td>$thread[$replies]</td>";
                                echo "<td>$thread[$posted]</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Board not found";
                        }
                        ?>
                    </tr>
                </table>
                <?php
                    if(isset($user))
                    {
                        if ($user->isLoggedIn())
                        {
                            require __DIR__ . '/newthread.php';
                        }
                    }
                ?>
            </div>
	</body>

</html>


