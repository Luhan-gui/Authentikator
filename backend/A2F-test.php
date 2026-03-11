<?php

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

$req=$bdd->prepare('INSERT INTO information (email, secret) VALUES (:email, :secret)');
//Création de l'OTP à partir de la clé
$otp = TOTP::createFromSecret($_GET['secret']);

//Vérification de l'OTP envoyé
if($otp->verify($_GET['otp']) == true){
    echo "Code correct";
    $req->execute(['email' => $_GET['email'], 'secret' => $_GET['secret']]);
}else{
    return http_response_code(403);
}
?>
