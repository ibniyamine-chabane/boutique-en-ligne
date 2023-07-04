<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<header>
        <div class="navbar">
            <div class="logo">
                <a href="#">
                    <img src="src/images/logo_bookhouse.png" alt="logo">
                </a>
            </div>
            <ul class="links">
                <?php if(isset($_SESSION['rights']) && $_SESSION["rights"] == "administrator") :?>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="shop.php">Boutique</a></li>
                    <li><a href="admin_dashboard.php">Admin</a></li>
                <?php else: ?>    
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="shop.php">Boutique</a></li>
                <?php endif; ?>
                <!-- <li><a href="hero">Contact</a></li> -->
            </ul>
            <?php require_once("research.php"); ?>    
            <div class="buttons">
            <?php if(isset($_SESSION['rights']) && $_SESSION["rights"] == "administrator" || isset($_SESSION['rights']) && $_SESSION["rights"] == "subscribed") :?>
                <a href="cart.php" class="action-button pro"><i class="fa-solid fa-cart-shopping"></i>Panier</a>
                <a href="profil.php" class="action-button pro">Profil</a>
                <a href="logout.php" class="action-button">Se déconnecter</a>
            <?php else: ?>
                <a href="register.php" class="action-button pro">Inscription</a>
                <a href="login.php" class="action-button">Se connecter</a>
            <?php endif; ?>    
            </div>
            <div class="burger-menu-button">
                <i class="fa-solid fa-bars"></i>
            </div>

        </div>
        <div class="burger-menu">
            <ul class="links">
            <?php if(isset($_SESSION['rights']) && $_SESSION["rights"] == "administrator") :?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="admin_dashboard.php">Admin</a></li>
            <?php else: ?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">Boutique</a></li>
            <?php endif ?>
                <!-- <li><a href="hero">Contact</a></li> -->
                <div class="divider">

                </div>
                <div class="buttons-burger-menu">
                <?php if(isset($_SESSION['rights']) && $_SESSION["rights"] == "administrator" || isset($_SESSION['rights']) && $_SESSION["rights"] == "subscribed") :?>
                    <a href="cart.php" class="action-button pro"><i class="fa-solid fa-cart-shopping"></i> Panier</a>
                    <a href="profil.php" class="action-button pro">Profil</a>
                    <a href="logout.php" class="action-button">Se déconnecter</a>
                <?php else: ?>
                    <a href="register.php" class="action-button pro">Inscription</a>
                    <a href="login.php" class="action-button">Se connecter</a> 
                <?php endif; ?>    
                </div>
            </ul>
        </div>    
        <script>
        const burgerMenuButton = document.querySelector('.burger-menu-button');
        const burgerMenuButtonIcon = document.querySelector('.burger-menu-button i');
        const burgerMenu = document.querySelector('.burger-menu');

        burgerMenuButton.onclick = function(){
            burgerMenu.classList.toggle('open');
            const isOpen = burgerMenu.classList.contains('open');
            burgerMenuButtonIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
        }
    </script>
    </header>