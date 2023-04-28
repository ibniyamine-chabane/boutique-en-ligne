<?php
session_start();

include('src/class/users.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="./src/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://js.stripe.com/v3/"></script>

  <title>Document</title>

</head>
<body>
  <?php include('header.php') ?>
    <form id="payment-form" method="post">
      <div>
        <label for="card-number">Numero de carte de crédit :</label>
        <input type="text" id="card-number" placeholder="**** **** **** ****" autocomplete="off" required>
      </div>
      <div>
        <label for="card-expiry">Date d'expiration :</label>
        <input type="text" id="card-expiry" class="form-control" placeholder="MM/YY" autocomplete="off" required>
      </div>
      <div>
        <label for="">CVC :</label>
        <input type="number" id="card-cvc" class="form-control" placeholder="***" autocomplete="off" required>
      </div>
      <input type="submit" value="Payer" class="btn btn-primary">

    </form>

    <script src="./src/js/checkout.js"></script>
    <?php include('footer.php') ?>
</body>
</html>

