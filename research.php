<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rechercher</title>
</head>
<body>
<form method="get" id="mon-formulaire">
  <label for="recherche">Rechercher:</label>
  <input type="text" id="recherche" name="q" autocomplete="off" required>
  <div id="suggestions"></div>
  <img src="" id="image" alt="">
  <button type="submit">Rechercher</button>
</form>
    <script src="src/js/research.js"></script>
</body>
</html>