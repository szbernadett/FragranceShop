<?php
session_start();
require_once "dao.php";

if (isset($_POST["delete"]) && isset($_POST["frag_id"])) {
    try {
        $dao->delete_fragrance($frag_id);
        $_SESSION["success"] = "Fragrance deleted.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Could not delete fragrance due to error: "
                . $e->getMessage();
    } finally {
        header("Location: member_page.php");
        return;
    }
}

$frag_id = $_GET["frag_id"];
$fragrances = $dao->get_fragrances();
$fragrance_name = $fragrances[$frag_id];

?>
<html>
    <h1>Delete Fragrance</h1>
    <p>Do you wish to delete <?= $fragrance_name ?> ?</p>
    <input type="hidden" name="frag_id" value=$frag_id>
    <input type="submit" name="delete" value="Delete">
    <a href="member_page.php">Cancel</a>
</html>

