<?php 
// dans cette page il faudrat récupérer la quantité deproduit disponible du produit , et les infos du produit
// les table products et product_inventory devront etre appeler, 
// le formulaire une fois valider devra envoyer les données récupérer en post vers la table cart.
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit</title>
</head>
<body>
    <main>
        <div></div>
        <section>
            <h2>titre du produit</h2>
            <div>
                <img src="" alt="">
            </div>
            <article>
                <h3>descrition du produit</h3>
                <aside>
                    <p></p>
                </aside>
            </article>
            <div>
                <form action="">
                    <label for="product_quantity">quantité :</label>
                    <input type="hidden" value=""><!-- ici la value sera l'id de l'user inscrit -->
                    <input type="hidden" value=""><!-- ici la value sera l'id du produit -->
                    <input type="number" maxlength="4" size="4" min="1" max="5"><!-- le max sera la quantité disponible pour ce produit, ce champ a mettre en width: 39px ne pas oublier de transformer le number en string-->
                    <input type="submit" value="ajouté au panier"> 
                </form>
            </div>
        </section>
    </main>
</body>
</html>