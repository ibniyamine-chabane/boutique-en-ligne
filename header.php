
<header>    
    <div class="logo">
        <img src="src/image/" alt="logo">
    </div>
    <nav>
        <ul>
            <?php if(isset($_SESSION['rights']) && $_SESSION["rights"] == "administrator") :?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">boutique</a></li>
                <li><a href="admin_dashboard.php">admin</a></li>
                <li><a href="profil.php">profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <li><a href="cart.php">panier</a></li>
            <?php elseif(isset($_SESSION['rights']) && $_SESSION["rights"] == "subscribed") :?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">boutique</a></li>
                <li><a href="profil.php">profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <li><a href="cart.php">panier</a></li>
            <?php else: ?>  
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">boutique</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">inscription</a></li>
            <?php endif; ?>
        </ul>
        <?php require_once("research.php"); ?>
    </nav>
</header>