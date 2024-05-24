<?php
session_start();

if (isset($_POST["send"])) {
    $_SESSION["success"] = "Message sent.";
    header("Location: contact.php");
    exit();
}
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
            <?php
            if (isset($_SESSION["success"])) {
                echo "<p style='color: green'>" . $_SESSION["success"] . "</p>";
                unset($_SESSION["success"]);
            }

            if (isset($_SESSION["error"])) {
                echo "<p style='color: red'>" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
            }
            ?>
            <h2>Contact Us</h2>
            <form method="post" style="margin-top: 30px">
                <label for="username">Name:</label> 
                <input type="text" name="username" id="username" style="display: block; margin-bottom: 30px;">
                <label for="email">Email:</label>
                <input type="text" name="email"id="email" style="display: block; margin-bottom: 30px;">
                <label for="message">Message:</label>
                <textarea name="message" id="message" style="display: block; margin-bottom: 20px;"></textarea>
                <input type="submit"  name="send" value="Send">
            </form>
            <a href="index.php">Cancel</a>
        </main>
        <?php include "footer.php"; ?>
    </body>
</html>

