<?php
session_start();
require_once 'model\dao.php';
$brands_by_name = $dao->get_brands_by_name();
$genders_by_value = $dao->get_genders_by_value();
$categories_by_value = $dao->get_categories_by_value();
$sizes_by_value = $dao->get_sizes_by_value();
$price_sizes = $dao->get_price_sizes();


if (isset($_POST["save"])) {
    $name = $_POST["name"];
    $brand = $brands_by_name[$_POST["brand"]];
    $gender = $genders_by_value[$_POST["gender"]];
    $description = $_POST["description"];
    $cats = $_POST["categories"];
    $selected_categories=[];
    foreach($cats as $cat){
        $selected_categories[] = Category::from($cat);
    }
    $ps_ids = $_POST["price_sizes"];
    $selected_price_sizes = [];
    foreach($ps_ids as $ps_id){
        $selected_price_sizes[]=$price_sizes[0+$ps_id];
    }
    
    $new_frag = new Fragrance(
            null,
            $name,
            $brand,
            $gender,
            $description,
            "",
            $selected_categories,
            $selected_price_sizes
    );
    try {
        $dao->save_fragrance($new_frag);
    } catch (PDOException $e) {
        $_SESSION["error"] = "Could not save fragrance due to error: "
                . $e->getMessage();
    } finally {
        header("Location: member_page.php");
        return;
    }
}
?>
<html>
    <h1>Add Fragrance</h1>
    <form method="post">
        <label>Name: </label>
        <input type="text" value="">
        <label>Brand: </label>
        <select name="brand" id="brands">
            <?php
            foreach ($brands_by_name as $name => $brand) {
                echo "<option value='$name'>$name</option>";
            }
            ?>
        </select>
        <fieldset>
            <legend>Gender: </legend>
            <?php
            foreach ($genders_by_value as $gender_value => $gender) {
                echo "<input type='radio' value=$gender_value id=$gender_value name='gender'>"
                . "<label for=$gender_value>$gender_value</label>";
            }
            ?>
        </fieldset>
        <fieldset>
            <legend>Category: </legend>
            <?php
            foreach ($categories_by_value as $cat_value => $cat) {
                echo"<input type='checkbox' name='categories[]' value=$cat_value id=$cat_value>"
                . "<label for=$cat_value>$cat_value</label>";
            }
            ?>
        </fieldset>
        <fieldset>
            <legend>Size: </legend>
                <?php
                foreach ($sizes_by_value as $size_value => $size) {
                    echo"<input type='checkbox' name='sizes[]' value=$size_value id=$size_value>"
                    . "<label for=$size_value>$size_value</label>";
                }
                ?>    
        </fieldset>
        <fieldset>
           <legend>Price per size: </legend>
                <?php
                foreach ($price_sizes as $id => $price_size) {
                    $identifier="".$id;
                    $display_val=$price_size->get_size()->value.": ".$price_size->get_price_value();
                    echo"<input type='checkbox' name='price_sizes[]' value=$identifier id=$identifier>"
                    . "<label for=$identifier>$display_val</label>";
                }
                ?>     
        </fieldset>
        <label for="description">Description: </label>
        <textarea name="description" id="description"></textarea>
        <label for="imageUpload">Image: </label>
        <input type="file" name="imageUpload" id="imageUpload">
        <input type="submit" name="save" value="Save">
        <a href="member_page.php">Cancel</a>
    </form>
</html>

