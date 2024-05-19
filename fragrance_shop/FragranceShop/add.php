<?php
session_start();
require_once 'model\dao.php';
$brands_by_name = $dao->get_brands_by_name();
$genders_by_value = $dao->get_genders_by_value();
$categories_by_value = $dao->get_categories_by_value();
$sizes_by_value = $dao->get_sizes_by_value();
$price_sizes = $dao->get_price_sizes();

$fname = $_SESSION["fname"] ??  "";
$brand_name = $_SESSION["brand_name"] ?? "";
$gender_name =$_SESSION["gender_name"] ?? "";
$description = $_SESSION["description"] ?? "";
$cats = $_SESSION["categories"] ?? [];
$message=""; // Variable to hold error message

if (isset($_POST["save"])) {   
    // check if all form data has been submitted
    if(isset($_POST["fname"]) && !empty(trim($_POST["fname"]))){
        $fname=$_POST["fname"];
        $_SESSION["fname"] = $fname;
    } else {
        if(!$message){ // only set an error message if the string is empty 
            $message="Please provide a valid name"; // this will be passed on to the Session even
                                                    // if there are other unset fields 
        }
    }
    
    if (isset($_POST["brand"])) {
        $brand_name = $_POST["brand"];
        $brand = $brands_by_name[$brand_name];
        $_SESSION["brand_name"] = $brand_name;
    } else {
        if(!$message){
            $message="Please select a brand";
        }
    }
    
    if(isset($_POST["gender"])){
        $gender_name = $_POST["gender"];
        $gender = Gender::from($gender_name);
        $_SESSION["gender_name"] = $gender_name;
    } else {
        if(!$message){
            $message="Please select a gender";
        }
    }
    
        if(isset($_POST["categories"])){
        $cats = $_POST["categories"];
        $_SESSION["categories"] = $cats;
        $selected_categories = [];
        foreach ($cats as $cat) {
            $selected_categories[] = Category::from($cat);
        }
    } else {
        if(!$message){
            $message="Please select at least one category";
        }
    }
    
    if(isset($_POST["description"]) && !empty(trim($_POST["description"]))){
        $description = $_POST["description"];
        $_SESSION["description"] = $description;
    } else {
        if(!$message){
            $message="Please provide a description";
        }
    }
    

    if($message){ // if the error message was set anywhere in the above code
        $_SESSION["error"]=$message; // pass on error message to Session to be shown when page reloads
        $message="";
        header("Location: add.php"); 
        return;
    }

    // handle image upload
    if (isset($_FILES["imageUpload"]) && $_FILES["imageUpload"]["error"] == 0) {
        $allowed = ["jpg", "jpeg", "png"];
        $fileName = $_FILES["imageUpload"]["name"];
        $fileTmpName = $_FILES["imageUpload"]["tmp_name"];
        $fileSize = $_FILES["imageUpload"]["size"];
        $fileError = $_FILES["imageUpload"]["error"];
        $fileType = $_FILES["imageUpload"]["type"];
        
        $parts = explode(".", $fileName);
        $fileExt = strtolower(end($parts)); 
        if (in_array($fileExt, $allowed)) {
            if ($fileSize < 5000000) { // be under 5MB
                $fileNewName = uniqid("", true) . "_" . $fileName; // add unique id to avoid overwriting
                $fileDestination = "resources/frag_images/" . $fileNewName;
                if (!move_uploaded_file($fileTmpName, $fileDestination)) {
                    $_SESSION["error"] = "Failed to upload image.";
                    header("Location: add.php");
                    return;
                }
            } else {
                $_SESSION["error"] = "File size exceeds 5MB limit.";
                header("Location: add.php");
                return;
            }
        } else {
            $_SESSION["error"] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            header("Location: add.php");
            return;
        }
    } else {
        $fileDestination = ''; // No image uploaded
    }
    
    // $_SESSION["fileDestination"]=$fileDestination;
    
    $new_frag = new Fragrance(
            $fname,
            $brand,
            $gender,
            $description,
            $fileDestination,
            $selected_categories
    );

    // save to database, if error occurs reload page, if successful return to member page
    try {
        $dao->save_fragrance($new_frag);
        $_SESSION["success"]="Fragrance saved to database.";
        unset($_SESSION["saving"]);
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
        header("Location: add.php");
        exit();
    } 
} 


?>
<html>
    <h1>Add Fragrance</h1>
<?php
if (isset($_SESSION["error"])) {
    echo "<p>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
    if($message){
        $message="";
    }
}
?>
    <form method="post" enctype="multipart/form-data">
        <label>Name: </label>
        <input type="text" name="fname" value="<?= htmlentities($fname) ?>" required>
        <label>Brand: </label>
        <select name="brand" id="brands" required>
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
                $checked =  $gender_value == $gender_name ? "checked" : "";
                echo "<input type='radio' value=$gender_value id=$gender_value name='gender' $checked>"
                . "<label for=$gender_value>$gender_value</label>";
            }
            ?>
        </fieldset>
        <fieldset>
            <legend>Category: </legend>
            <?php
            foreach ($categories_by_value as $cat_value => $cat) {
                echo"<input type='checkbox' name='categories[]' "
                . "value=$cat_value id=$cat_value>"
                . "<label for=$cat_value>$cat_value</label>";
            }
            ?>
        </fieldset>

        <label for="description">Description: </label>
        <textarea name="description" id="description"><?= htmlentities($description)?></textarea>

        <label for="imageUpload">Image: </label>
        <input type="file" name="imageUpload" id="imageUpload" 
               accept=".jpg, .jpeg, .png">
        <input type="submit" name="save" value="Save">
        <a href="member_page.php">Cancel</a>
    </form>


</html>

