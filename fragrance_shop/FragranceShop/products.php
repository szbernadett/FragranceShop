<?php
require_once "model\pdo.php";
require_once "model\dao.php";
session_start();

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

            <h2>Products</h2>
            <?php
            foreach ($fragrances as $fragrance) {
                $alt = htmlentities($fragrance->get_name());
                echo"<section>";
                echo"<table class='pure-u-1-2'>";
                echo"<tr>";
                echo"<td style='text-align: right; width: 50%'><img src ='" . $fragrance->get_img_src() . "' height='200' alt=$alt></td>";
                echo "<td style='text-align: left; width: 50%'>" . htmlentities($fragrance->get_name()) . "<br>"
                . $fragrance->get_brand()->get_brand_name() . "<br>"
                . $fragrance->get_gender()->value . "</td>";
                echo"</tr>";
                echo"<tr>";
                echo"<td colspan='2' style='line-height: 1.5'>" . htmlentities($fragrance->get_description()) . "</td>";
                echo"</tr>";
                echo"</table>";
                echo"</section>";
            }
            ?>
        </main>
    </body>
</html>

