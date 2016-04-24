
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
            <div class='thread'>
                <table border="1">
                    <tr>
                        <td><h3>User</h3></td>
                        <td><h3>Subject</h3></td>
                        <td><h3>Message</h3></td>
                        <td><h3>Post time</h3></td>
                    </tr>
                    <tr>
                        <?php
                        if(isset($_GET['threadname']))
                        {
                            $db = new DataBase();
                            $posts = $db->getPosts($session->get('currentthread'));
                            $subject = 'PostName';
                            $postmessage = 'PostMessage';
                            $posttime = 'PostDate';
                            $postername = 'Name';
                            foreach($posts as $post)
                            {
                                $postdate = $post[$posttime];
                                $postname = $post[$subject];
                                $poster = $db->getPoster($postname, $postdate);
                                echo "<tr>";
                                echo "<td>$poster[$postername]</td>";
                                echo "<td>$postname</td>";
                                echo "<td>$post[$postmessage]</td>";
                                echo "<td>$postdate</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Thread not found";
                        }
                        ?>
                    </tr>
                </table>
                <?php
                    if(isset($user))
                    {
                        if ($user->isLoggedIn())
                        {
                            require __DIR__ . '/newpost.php';
                        }
                    }
                ?>
            </div>
	</body>

</html>
