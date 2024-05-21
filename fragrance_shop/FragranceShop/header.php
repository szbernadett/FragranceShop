
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

<header style="margin-bottom: 40px; border-bottom: 1px solid black;"> 
    <h1 style="display: inline-block; margin:0; margin-left: 20px;">Fragrance Shop</h1>
    <img src="resources/perfume_logo.jpg" alt="logo: a perfume bottle" height="48px" style="display: inline-block; margin-top: 10px;">
    <nav>
        <ul style="list-style:none; text-align: right;">
            <li style="display: inline-block; margin:0 20px 20px 20px;"><a href="index.php">Home</a></li>
            <li style="display: inline-block; margin:0 20px 20px 20px;"><a href="products.php">Products</a></li>
            <li style="display: inline-block; margin:0 20px 20px 20px;"><a href="contact.php">Contact Us</a></li>
            <li style="display: inline-block; margin:0 20px 20px 20px;"><a href=<?=$href?>><?=$text?></a></li>
            <li style="display: inline-block; margin:0 60px 20px 20px;"><a href="about.php">About Us</a></li>
        </ul>
    </nav>
</header>
