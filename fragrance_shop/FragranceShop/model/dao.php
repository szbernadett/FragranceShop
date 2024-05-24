<?php
require_once "pdo.php";
require_once "GeneralDAO.php";

try{
    $dao = new GeneralDAO($pdo);
} catch (PDOException $e) {
    echo "<p style='color:red'>" . "Could not access data" . $e.getMessage() . "</p>"; 
}

