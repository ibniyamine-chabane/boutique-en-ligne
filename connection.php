<?php include('header.php') ?>

        <div>
            <h2>Connexion</h2>
            <form id="form-log" method="post">
                <label for="email">email</label>
                <input type="email" name="email" required>
                <label for="password">password</label>
                <input type="password" name="password" required>
                <input type="submit" name="submit" value="valider">
            </form>
        </div>

        <script src="login.js"></script>
