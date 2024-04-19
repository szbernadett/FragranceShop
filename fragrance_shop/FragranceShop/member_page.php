<?php
require_once "model\dao.php";
session_start();
if(!isset($_SESSION["member"])){
    header("Location: login.php");
    return;
}
$fragrances = $dao->get_fragrances();
?>
<html>
    <?php
    include "header.php";

    if (isset($_SESSION["success"])) {
        echo "<p>" . $_SESSION["success"] . "</p>";
        unset($_SESSION["success"]);
    }

    if (isset($_SESSION["error"])) {
        echo "<p>" . $_SESSION["error"] . "</p>";
        unset($_SESSION["error"]);
    }
    
    echo "<a href='logout.php'>Log Out</a>";
    echo "<a href='add.php'>Add New Fragrance</a>";

    foreach ($fragrances as $frag) {
        echo"<table style='width: 100%;'>";
            echo"<tr>";
                echo"<td style='width: 50%;'>";
                    echo"<table style='width: 100%; max-width: 100%;'>";
                    echo"<tr>";
                    echo"<td>Image</td>";
                    echo"<td><img src='" . $frag->get_img_src() . "' width='100' height='100'></td>";
                    echo"</tr>";
                    echo"<tr>";
                    echo"<td>Name</td>";
                    echo"<td>" . $frag->get_name() . "</td>";
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
                    echo"<td>" . $frag->get_description() . "</td>";
                    echo"</tr>";
                    echo"</table>";
                echo"</td>";
                echo"<td style='width: 20%;'>";
                    echo"<a href='edit.php?frag_id=".$frag->get_id()."'>Edit</a>";
                    echo "<a href='delete.php?frag_id=".$frag->get_id()."'>Delete</a>";
                echo"</td>";
            echo"</tr>";
        echo"</table>";
    }
    ?>
    <?php include "footer.php" ?>
</html>



