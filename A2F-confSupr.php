<!-- 
    Fichier : A2F-confSupr.php
    Description : Page de confirmation de la désactivation de l'authentification à deux facteurs (A2F) pour les 
                 utilisateurs d'Alizon, informant les utilisateurs que leur compte n'est plus protégé par 
                 l'A2F et fournissant des instructions sur la manière de gérer cette fonctionnalité de sécurité.
    Auteur : SkibidiCorp - Luhan
    Date de création : 17/03/2026
    Libraries utilisées : X
-->

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Alizon - A2F</title>
</head>

<body>
    <main>
        <img class="logo" src="img/logo_alizon_front.svg" alt="Logo Alizon">
        <section class="container">
            <h4>Désactivation de l’authentification à deux facteurs (A2F) réussi !</h4>
            <p>Votre compte Alizon n'est plus protégé par l'authentification à double facteurs (A2F). À chaque
                connexion, vous devrez fournir uniquement votre mot de passe pour accéder à votre compte. Cependant,
                veuillez noter que la désactivation de l'A2F expose votre compte à un risque accru de compromission, car
                vous ne bénéficierez plus de la protection supplémentaire offerte par l'authentification à deux
                facteurs. Nous vous recommandons vivement de réactiver l'A2F pour garantir la sécurité maximale
                de votre compte Alizon.</p>
        </section>
        <a class="bouton" href="A2F-term.php">Fin</a>
        <a class="btnJaune" href="index.php">Accueil</a>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>