<footer> 
  <div class="footer-links">
    <h3>Navigation</h3>
    <ul>
            <?php if(isset($_SESSION['rights']) && $_SESSION["rights"] == "administrator") :?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="admin_dashboard.php">Admin</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <li><a href="cart.php">Panier</a></li>
            <?php elseif(isset($_SESSION['rights']) && $_SESSION["rights"] == "subscribed") :?>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">boutique</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <li><a href="cart.php">Panier</a></li>
            <?php else: ?>  
                <li><a href="index.php">Accueil</a></li>
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            <?php endif; ?>
        </ul>
  </div>
  <script src="footer.js"></script>

  <div class="footer-contact">
    <h3>Contact</h3>
    <p>Pour toute question ou demande, n'hésitez pas à nous contacter :</p>
    <ul>
      <li><a href="mailto:collaborateur1@example.com">ibni-yamine.chabane@laplateforme.io</a></li>
      <li><a href="mailto:collaborateur2@example.com">samuel-durand@laplateforme.io</a></li>
      <li><a href="mailto:collaborateur3@example.com">joris-landaret@laplateforme.io</a></li>
    </ul>
  </div>
</footer>
