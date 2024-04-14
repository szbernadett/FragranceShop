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
                $_SESSION["login_nav_text"]="Hello, " . $member->get_username();
                $_SESSION["login_nav_href"]="member_page.php";
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
    <?php
    if (isset($_SESSION["error"])) {
        echo "<p>" . $_SESSION["error"] . "</p>";
        unset($_SESSION["error"]);
    }
    ?>
    <form method="post">
        Username: <input type="text" name="username">
        Password: <input type="text" name="password">
        <input type="submit" value="Log In">
    </form>