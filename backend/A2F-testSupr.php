<?php
//    Fichier : A2F-test.php
//    Description : Programme de vérification du code OTP envoyé par le client pour l'activation de l'authentification à 
//                    deux facteurs. Ce script reçoit les informations nécessaires (email, secret, OTP) via une requête GET en AJAX, 
//                    vérifie la validité du code OTP en utilisant la bibliothèque OTPHP, et si le code est correct, 
//                    il enregistre les informations dans la base de données PostgreSQL. En cas d'erreur ou de code incorrect, 
//                    il renvoie un code de réponse HTTP 403 pour indiquer que l'accès est refusé.
//    Auteur : SkibidiCorp - Luhan
//    Date de création : 09/03/2026
//    Libraries utilisées : OTPHP (pour la génération de TOTP)

// Charge les dépendances de Composer
require_once '../vendor/autoload.php';

use OTPHP\TOTP;

require_once('../_env.php');
loadEnv('../.env');

//Récupérer les variables
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');

//connexion à PostgreSQL
try {
    $ip = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';';
    $bdd = new PDO($ip, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    // "✅ Connecté à PostgreSQL ($dbname)";
    $bdd->query('set schema \'authentikator\'');
} catch (PDOException $e) {
    // "❌ Erreur de connexion : " . $e->getMessage();
}
$cle = $bdd->prepare('SELECT secret FROM information WHERE email = :email');
$cle->execute(['email' => $_GET['email']]);
$cle = $cle->fetch();
$req = $bdd->prepare('DELETE FROM information WHERE email = :email');
//Création de l'OTP à partir de la clé
$otp = TOTP::createFromSecret($cle[0]);

//Vérification de l'OTP envoyé
if ($otp->verify($_GET['otp']) == true) {
    echo "Code correct";
    $req->execute(['email' => $_GET['email']]);
} else {
    return http_response_code(403);
}
?>