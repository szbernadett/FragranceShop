<?php
session_start();
require_once 'model\dao.php';
$brands_by_name = $dao->get_brands_by_name();
$genders_by_value = $dao->get_genders_by_value();
$categories_by_value = $dao->get_categories_by_value();
$sizes_by_value = $dao->get_sizes_by_value();
$price_sizes = $dao->get_price_sizes();
$fragrances = $dao->get_fragrances();

if (!isset($_SESSION["editing"])) {
    if (!isset($_GET["frag_id"])) {
        $_SESSION["error"] = "Missing fragrance ID";
        header("Location: member_page.php");
        exit();
    } else {
        if (!isset($_SESSION["frag_id"])) {
            $_SESSION["frag_id"] = $_GET["frag_id"];
        }
    }
}

$frag_id = $_SESSION["frag_id"];
$frag_to_edit = $fragrances[$frag_id];
$fname = $_SESSION["fname"] ?? $frag_to_edit->get_name();
$brand_name = $_SESSION["brand_name"] ?? $frag_to_edit->get_brand()->get_brand_name();
$gender_name = $_SESSION["gender_name"] ?? $frag_to_edit->get_gender()->value;
$description = $_SESSION["description"] ?? $frag_to_edit->get_description();
$categories = $_SESSION["categories"] ?? $frag_to_edit->get_categories();
$message = ""; // Variable to hold error message

if (isset($_POST["save"])) {
    // check if all form data has been submitted
    $_SESSION["editing"] = true;
    if (isset($_POST["fname"]) && !empty(trim($_POST["fname"]))) {
        $fname = $_POST["fname"];
        $_SESSION["fname"] = $fname;
    } else {
        if (!$message) { // only set an error message if the string is empty 
            $message = "Please provide a valid name"; // this will be passed on to the Session even
            // if there are other unset fields 
        }
    }

    if (isset($_POST["brand"])) {
        $brand_name = $_POST["brand"];
        $brand = $brands_by_name[$brand_name];
        $_SESSION["brand_name"] = $brand_name;
    } else {
        if (!$message) {
            $message = "Please select a brand";
        }
    }

    if (isset($_POST["gender"])) {
        $gender_name = $_POST["gender"];
        $gender = Gender::from($gender_name);
        $_SESSION["gender_name"] = $gender_name;
    } else {
        if (!$message) {
            $message = "Please select a gender";
        }
    }

    if (isset($_POST["categories"])) {
        $cats = $_POST["categories"];
        $_SESSION["categories"] = $cats;
        $selected_categories = [];
        foreach ($cats as $cat) {
            $selected_categories[] = Category::from($cat);
        }
    } else {
        if (!$message) {
            $message = "Please select at least one category";
        }
    }

    if (isset($_POST["description"]) && !empty(trim($_POST["description"]))) {
        $description = $_POST["description"];
        $_SESSION["description"] = $description;
    } else {
        if (!$message) {
            $message = "Please provide a description";
        }
    }


    if ($message) { // if the error message was set anywhere in the above code
        $_SESSION["error"] = $message; // pass on error message to Session to be shown when page reloads
        $message = "";
        header("Location: edit.php");
        return;
    }

    // handle image upload
    if (isset($_FILES["imageUpload"]) && $_FILES["imageUpload"]["error"] == 0) {
        $allowed = ["jpg", "jpeg", "png"];
        $file_name = $_FILES["imageUpload"]["name"];
        $file_tmp_name = $_FILES["imageUpload"]["tmp_name"];
        $file_size = $_FILES["imageUpload"]["size"];
        $file_error = $_FILES["imageUpload"]["error"];
        $file_type = $_FILES["imageUpload"]["type"];

        $parts = explode(".", $file_name);
        $file_ext = strtolower(end($parts));
        if (in_array($file_ext, $allowed)) {
            if ($file_size < 5000000) { // be under 5MB
                $file_new_name = uniqid("", true) . "_" . $file_name; // add unique id to avoid overwriting
                $file_destination = "resources/frag_images/" . $file_new_name;
                if (!move_uploaded_file($file_tmp_name, $file_destination)) {
                    $_SESSION["error"] = "Failed to upload image.";
                    header("Location: edit.php");
                    return;
                }
            } else {
                $_SESSION["error"] = "File size exceeds 5MB limit.";
                header("Location: edit.php");
                return;
            }
        } else {
            $_SESSION["error"] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            header("Location: edit.php");
            return;
        }
    } else {
        $file_destination = $frag_to_edit->get_img_src(); // No image uploaded
    }


    $frag_to_edit->set_name($fname);
    $frag_to_edit->set_brand($brand);
    $frag_to_edit->set_gender($gender);
    $frag_to_edit->set_description($description);
    $frag_to_edit->set_img_src($file_destination);
    $frag_to_edit->set_categories($selected_categories);

    // save changes to database, if error occurs reload page, if successful return to member page
    try {
        $dao->update_fragrance($frag_to_edit);
        $_SESSION["success"] = "Fragrance updated.";
        unset($_SESSION["editing"]);
        unset($_SESSION["frag_id"]);
        unset($_SESSION["fname"]);
        unset($_SESSION["brand_name"]);
        unset($_SESSION["gender_name"]);
        unset($_SESSION["description"]);
        unset($_SESSION["categories"]);
        header("Location: member_page.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Could not save fragrance due to error: "
                . $e->getMessage();
        header("Location: edit.php");
        exit();
    }
}
?>
<html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1"
    </head>
    <body>
        <main style="margin: 20px 40px" id="main"  tabindex ="-1">
            <h2>Edit Fragrance</h2>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<p>" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
                if ($message) {
                    $message = "";
                }
            }
            ?>
            <form method="post" enctype="multipart/form-data">
                <label>Name: </label>
                <input type="text" name="fname" style="margin-right: 10px" value="<?= htmlentities($fname) ?>">
                <label>Brand: </label>
                <select name="brand" id="brands" style="margin-bottom: 20px">
                    <?php
                    foreach ($brands_by_name as $name => $brand) {
                        $selected = $name == $brand_name ? "selected" : "";
                        echo "<option value='$name' $selected>$name</option>";
                    }
                    ?>
                </select>
                <fieldset style="margin-bottom: 20px">
                    <legend>Gender: </legend>
                    <?php
                    foreach ($genders_by_value as $gender_value => $gender) {
                        $checked = $gender_value == $gender_name ? "checked" : "";
                        echo "<input type='radio' value=$gender_value id=$gender_value name='gender'"
                                . "style='margin: 0 5px 0 15px' $checked>"
                        . "<label for=$gender_value>$gender_value</label>";
                    }
                    ?>
                </fieldset>
                <fieldset style="margin-bottom: 20px">
                    <legend>Category: </legend>
                    <?php
                    foreach ($categories_by_value as $cat_value => $cat) {
                        $checked = in_array($cat, $categories) ? "checked" : "";
                        echo"<input type='checkbox' name='categories[]' "
                        . "value=$cat_value id=$cat_value style='margin: 0 5px 0 15px'$checked>"
                        . "<label for=$cat_value>$cat_value</label>";
                    }
                    ?>
                </fieldset>

                <label for="description">Description: </label>
                <textarea name="description" id="description" style="display: block; margin-bottom: 20px">
                    <?= htmlentities($description) ?>
                </textarea>

                <label for="imageUpload">Image: </label>
                <input type="file" name="imageUpload" id="imageUpload" 
                       accept=".jpg, .jpeg, .png" style="display: block; margin-bottom: 20px;">
                <input type="submit" name="save" value="Save">
            </form>
            <a href="member_page.php">Cancel</a>
        </main>
    </body>
</html>

