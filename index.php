<!-- 
    Fichier : index.php
    Description : Page de départ de l'authentification à deux facteurs (A2F) pour tester dans l'environnement.
    Auteur : SkibidiCorp - Luhan
    Date de création : 13/03/2026
    Libraries utilisées : X
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2F-Menu Principal</title>
</head>
<body>
    <h1>Bonjour !</h1>
    Bienvenue sur la page de démonstration de l'authentification à deux facteurs (A2F). <br>
    Cette page sert à rentrer des informations pour tester l'implémentation de l'A2F. <br>
    Rentrer dans les champs suivants une adresse email afin de pouvoir tester l'implémentation de l'A2F. <br>
    <form>
        <input type="email" id="email" name="email" placeholder="Entrez votre adresse email" required>
        <button type="submit">Valider</button>
    </form>
    <script>
        let inputEmail = document.getElementById("email");
        let email = inputEmail.value;
        document.cookie = 'email=' + email;
    </script>
</body>
</html>