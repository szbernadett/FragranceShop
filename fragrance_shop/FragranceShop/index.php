<?php
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1"
    </head>
    <body>
        <?php include "header.php"; ?>
        <main style="margin: 20px 40px" id="main"  tabindex ="-1">
            <h2>Home</h2>
            <p><em> Please log in via the link above to add, edit and delete fragrances. </em></p>
            <p style="line-height: 1.5"> 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut 
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor 
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
                sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </main>
        <?php
        include "footer.php";
        ?>
    </body>
</html>
