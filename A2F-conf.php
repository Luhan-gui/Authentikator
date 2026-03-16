<!-- 
    Fichier : A2F-conf.php
    Description : Page de confirmation de l'activation de l'authentification à deux facteurs (A2F) pour les 
                utilisateurs d'Alizon, informant les utilisateurs que leur compte est désormais protégé par 
                l'A2F et fournissant des instructions sur la manière de gérer cette fonctionnalité de sécurité.
    Auteur : SkibidiCorp - Luhan
    Date de création : 09/03/2026
    Libraries utilisées : X
-->

<?php
session_start();
//if (!isset($_SESSION['user_id'])) {
//    header('Location: login.php');
//    exit();
//}
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
            <h4>Activation de l’authentification à deux facteurs (A2F) réussi !</h4>
            <p>Votre compte Alizon est désormais protégé par l'authentification à double facteurs (A2F). À chaque
                connexion, vous devrez fournir votre mot de passe ainsi que le code de vérification à six chiffres
                généré par votre application d'authentification. Cette mesure de sécurité supplémentaire garantit que
                même si quelqu'un obtient votre mot de passe, il ne pourra pas accéder à votre compte sans le code de
                vérification. Nous vous recommandons vivement de conserver votre clé secrète en lieu sûr et de ne pas la
                partager avec d'autres personnes. En cas de perte de votre appareil ou de votre clé secrète, veuillez
                contacter notre support client pour obtenir de l'aide afin de réinitialiser votre A2F et sécuriser à
                nouveau votre compte Alizon.</p>
        </section>
        <a class="bouton" href="A2F-conn.php">Mon Compte</a>
        <a class="btnJaune" href="index.php">Accueil</a>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>