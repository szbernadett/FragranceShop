<?php
require_once 'model\dao.php';
require_once 'model\Member.php';

session_start();

if (!isset($_SESSION["member"])) {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $member = $dao->get_member($_POST["username"]);
        if ($member !== null) {
            if (password_verify($_POST["password"], $member->get_password())) {
                $_SESSION["member"] = $member;
                $_SESSION["login_nav_text"] = "Hello, " . $member->get_username();
                $_SESSION["login_nav_href"] = "member_page.php";
                $_SESSION["success"] = "Successfully logged in.";
                header("Location: member_page.php");
                return;
            } else {
                echo "wrong pass";
                $_SESSION["error"] = "Password incorrect";
                header("Location: login.php");
                return;
            }
        } else {
            $_SESSION["error"] = "No user found with this name";
            header("Location: login.php");
            return;
        }
    }
} else {
    unset($_SESSION["member"]);
    unset($_SESSION["login_nav_text"]);
    unset($_SESSION["login_nav_href"]);
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
        if (isset($_SESSION["error"])) {
            echo "<p>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]);
        }
        ?>
        <h2>Log In</h2>
        <form method="post" style="margin-top: 30px">
            <label for="username">Username:</label> 
            <input type="text" name="username" id="username" style="display: block; margin-bottom: 30px;">
            <label for="password">Password:</label>
            <input type="text" name="password"id="password" style="display: block; margin-bottom: 20px;">
            <input type="submit" value="Log In">
        </form>
        <a href="index.php">Cancel</a>
    </main>
        <?php include "footer.php"; ?>
    </body>
</html>