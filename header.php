<header>    
    <nav>
        <div class="mobile-menu-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul>
            <?php if(isset($_SESSION['rights'])) :?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">boutique</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <li><a href="admin_dashboard.php">admin</a></li>
            <?php else: ?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">boutique</a></li>
                <li><a href="connection.php">Connexion</a></li>
                <li><a href="register.php">inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>