<?php
//    Fichier : A2F-tesCon.php
//    Description : Programme de vérification du code OTP envoyé par le client pour confirmer la connexion. 
//                    Ce script reçoit les informations nécessaires (email, secret, OTP) via une requête GET en AJAX, 
//                    vérifie la validité du code OTP en utilisant la bibliothèque OTPHP, et si le code est correct, 
//                    il renvoie ok. En cas d'erreur ou de code incorrect, 
//                    il renvoie un code de réponse HTTP 403 pour indiquer que l'accès est refusé.
//    Auteur : SkibidiCorp - Luhan
//    Date de création : 16/03/2026
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

//Récupération de la clé secrète associée à l'email
$req = $bdd->prepare('SELECT secret FROM information WHERE email = :email');
$req->execute(['email' => $_GET['email']]);
$res = $req->fetchAll(PDO::FETCH_ASSOC);

//Création de l'OTP à partir de la clé
$otp = TOTP::createFromSecret($res[0]['secret']);

//Vérification de l'OTP envoyé
if ($otp->verify($_GET['otp']) == true) {
    echo "Code correct";
} else {
    return http_response_code(403);
}
?>