
<!-- HEADER -->
<?php
    if(isset($_SESSION["login_nav_text"]) && isset($_SESSION["login_nav_href"])){
        $href =$_SESSION["login_nav_href"];
        $text=$_SESSION["login_nav_text"];
    } else {
        $href ="login.php";
        $text="Log In";    
    }
?>

<header> 
    <img src="resources/perfume_logo.jpg" alt="logo: a perfume bottle" height="48px">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href=#>Products</a></li>
            <li><a href=#>Contact Us</a></li>
            <li><a href=<?=$href?>><?=$text?></a></li>
            <li><a href=#>About Us</a></li>
        </ul>
    </nav>
</header>
