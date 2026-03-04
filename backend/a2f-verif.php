<?php 
use OTPHP\TOTP;
    $secret = "AzeazdZ67831bdsfx";
    $otp = new TOTP($secret);
    /* $bdd->prepare('SELECT secret FROM authentikator WHERE email = :email')
        $email = htmlspecialchars(strip_tags($email));
    */
    /*// Récupérer les variables
    $host = getenv('PGHOST');
    $port = getenv('PGPORT');
    $dbname = getenv('PGDATABASE');
    $user = getenv('PGUSER');
    $password = getenv('PGPASSWORD');
    
    // Connexion à PostgreSQL

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        $bdd = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $bdd->query('set schema \'authentikator\'');
    */
    $email = $_GET["email"];
    $codepin = $_GET["pin"];

    if($otp->verify($secret,$codepin))
        return http_response_code(202);
    else
        return http_response_code(403);
