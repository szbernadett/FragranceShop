<?php
require_once "model\pdo.php";
require_once "model\dao.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$fragrances = $dao->get_fragrances();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include "header.php";
        ?>
        <h1>Title</h1>
        <?php
        foreach ($fragrances as $fragrance) {
            echo "<table style='max-width: 50%'>";
            echo"<tr>";
            echo"<td style='text-align: right; width: 50%'><img src ='" . $fragrance->get_img_src() . "' width='200' height='200'></td>";
            echo "<td style='text-align: left; width: 50%'>" . $fragrance->get_name() . "<br>"
            . $fragrance->get_brand()->get_brand_name() . "<br>"
            . $fragrance->get_gender() . "</td>";
            echo"</tr>";
            echo "<tr>";
            echo"<td colspan='2'>" . $fragrance->get_description() . "</td>";
            echo"</tr>";
            echo"</table>";
        }
        ?>
        <?php
        include "footer.php";
        ?>
    </body>
</html>
