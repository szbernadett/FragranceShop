<?php
session_start();
require_once "model\dao.php";

if (isset($_POST["delete"]) && isset($_POST["frag_id"])) {
        $frag_id=$_POST["frag_id"];
    try {
        $dao->delete_fragrance($frag_id);
        $_SESSION["success"] = "Fragrance deleted.";
        header("Location: member_page.php");
        exit(); 
    } catch (PDOException $e) {
        $_SESSION["error"] = "Could not delete fragrance due to error: "
                . $e->getMessage();
    } 
}

if ( ! isset($_GET["frag_id"]) ) {
  $_SESSION["error"] = "Missing fragrance ID";
  header("Location: member_page.php");
  exit();
}

$frag_id = $_GET["frag_id"];
var_dump($frag_id);
$fragrances = $dao->get_fragrances();
$fragrance_name = $fragrances[$frag_id]->get_name();

?>

<html>
    <h1>Delete Fragrance</h1>
    <p>Do you wish to delete <?= $fragrance_name ?> ?</p>
    
    <form method="post">
        <input type="hidden" name="frag_id" value="<?= $frag_id ?>">
    <input type="submit" name="delete" value="Delete">
    </form>
    
    <a href="member_page.php">Cancel</a>
</html>

