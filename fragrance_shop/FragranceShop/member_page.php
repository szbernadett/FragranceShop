<?php
require_once "model\dao.php";
session_start();
if (!isset($_SESSION["member"])) {
    header("Location: login.php");
    return;
}
$fragrances = $dao->get_fragrances();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1"
    </head>
    <body>
        <?php include "header.php"; ?>
        <main style="margin: 20px 40px">
        <?php
        if (isset($_SESSION["success"])) {
            echo "<p style='color: green'>" . $_SESSION["success"] . "</p>";
            unset($_SESSION["success"]);
        }

        if (isset($_SESSION["error"])) {
            echo "<p style='color: red'>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]);
        }

        echo "<a href='logout.php' style='margin-right: 20px'>Log Out</a>";
        echo "<a href='add.php'>Add New Fragrance</a>";

        foreach ($fragrances as $frag) {
            echo"<table style='width: 100%; margin-top: 20px;'>";
            echo"<tr>";
            echo"<td style='width: 30%;'>";
            echo"<table style='width: 100%; max-width: 100%;'>";
            echo"<tr>";
            echo"<td>Image</td>";
            $alt = htmlentities($fragrance->get_name());
            echo"<td><img src='" . $frag->get_img_src() . "' height='100' alt=$alt></td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td>Name</td>";
            echo"<td>" . htmlentities($frag->get_name()) . "</td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td>Brand</td>";
            echo"<td>" . $frag->get_brand()->get_brand_name() . "</td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td>Gender</td>";
            echo"<td>" . $frag->get_gender()->value . "</td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td>Category</td>";

            echo"<td>" . implode(", ", Category::string_values($frag->get_categories())) . "</td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td>Description</td>";
            echo"<td style='line-height: 1.5'>" . htmlentities($frag->get_description()) . "</td>";
            echo"</tr>";
            echo"</table>";
            echo"</td>";
            echo"<td style='width: 20%;'>";
            echo"<a href='edit.php?frag_id=" . $frag->get_id() . "' style='margin-right: 20px'>Edit</a>";
            echo "<a href='delete.php?frag_id=" . $frag->get_id() . "'>Delete</a>";
            echo"</td>";
            echo"</tr>";
            echo"</table>";
        }
        ?>
    </main>
        <?php include "footer.php" ?>
    </body>
</html>



