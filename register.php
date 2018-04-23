<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Nothing Comes To Mind</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            div.container {
                width: 100%;
                border: 1px solid gray;
            }

            header, footer {
                padding: 1em;
                color: white;
                background-color: black;
                clear: left;
                text-align: center;
            }

            nav {
                float: left;
                max-width: 160px;
                margin: 0;
                padding: 1em;
            }

            nav ul {
                list-style-type: none;
                padding: 0;
            }

            nav ul a {
                text-decoration: none;
            }

            article {
                margin-left: 170px;
                border-left: 1px solid gray;
                padding: 1em;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                <h1>Nothing Comes To Mind</h1>
            </header>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="http://localhost/register.php?username=nothingcomestomind&password=php&submit=Submit">Pictures</a></li>
            </nav>
            <article>
                <h2>Registration Form</h2>
                <form method="get">
                    Username:<br>
                    <input type="text" name="username"><br>
                    Password:<br>
                    <input type="text" name="password"><br><br>
                    <input type="submit" name="submit" value="Submit"><br><br>
                </form>
                <?php
                if (isset($_GET["submit"])){
                    echo "You successfully registered with the Username: " . $_GET["username"];
                }
                ?>
            </article>
            <footer>NothingComesToMind.com</footer>
        </div>
    </body>
</html>