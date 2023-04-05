<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>validation commande</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <main>
        <section>
            <h2>détail de facturation</h2>
            <div>
                <form action="" method="post">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname">
                    <label for="lastname">Nom</label>
                    <input type="text" name="lastname">
                    <label for="country">Pays / region</label>
                    <input type="text" name="country">
                    <label for="address_line_1">Numéro et nom de rue</label>
                    <input type="text" name="address_line_1">
                    <label for="address_line_2">Complément d'adresse</label>
                    <input type="text" name="address_line_2">
                    <label for="postal_code">Code postal</label>
                    <input type="text" name="postal_code">
                    <label for="telephone">Télephone</label>
                    <input type="text" name="telephone">
                    <label for="mobile">mobile</label>
                    <input type="text" name="mobile">
                    <input type="submit" value="finaliser la commande">
                </form>
            </div>
            <div>
                <table>
                    
                </table>
            </div>
        </section>
    </main>
</body>
</html>