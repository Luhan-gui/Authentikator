<!-- 
    Fichier : A2F-code.php
    Description : Page de configuration de l'authentification à deux facteurs (A2F) pour les utilisateurs d'Alizon.
    Auteur : SkibidiCorp - Luhan
    Date de création : 09/03/2026
    Libraries utilisées : OTPHP (pour la génération de TOTP)
-->


<?php
session_start();

// Charge les dépendances de Composer
require_once __DIR__ . '/vendor/autoload.php';

use OTPHP\TOTP;
use OTPHP\InternalClock;

// Horloge pour génération de TOTP
$clock = new InternalClock();

// Récupère le cookie email inscrit lors de la validation de l'email dans index.php

$email = $_COOKIE['email'];

require_once('_env.php');
loadEnv('.env');

//Récupérer les variables
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');


//Génération du secret et du QR code pour l'utilisateur
$totp = TOTP::generate($clock, 16);
$totp = $totp->withLabel($email)
        ->withIssuer('Alizon Marketplace');
$goqr_me = $totp->getQrCodeUri(
    'https://api.qrserver.com/v1/create-qr-code/?color=000000&bgcolor=FFFFFF&data=[DATA]&qzone=2&margin=0&size=300x300&ecc=M',
    '[DATA]'
);
$secret = $totp->getSecret();

//if (!isset($_SESSION['user_id'])) {
//    header('Location: login.php');
//    exit();
//}

// Connexion à PostgreSQL
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
            <h4> Voici votre clé secrète : <?php echo $secret; ?></h4>
            <?php echo "<img src='{$goqr_me}' class='QR' alt='QR Code Alizon'>"; ?>
            <p> Veuillez entrer cette clé dans votre application d'authentification pour générer les codes de
                vérification à six chiffres nécessaires pour l'authentification à deux facteurs (A2F). Assurez-vous de
                conserver cette clé en lieu sûr, car elle est essentielle pour configurer votre compte Alizon avec
                l'application d'authentification. En cas de perte de cette clé, vous pourriez rencontrer des difficultés
                pour accéder à votre compte Alizon via l'A2F. </p>
            <p>Lorque vous avez entré la clé dans votre application d'authentification, veuillez rentrer votre code de
                vérification à six chiffres ci-dessous pour finaliser l'activation de l'authentification à deux facteurs
                (A2F) de votre compte Alizon.</p>
            <form id="otpForm">
                <h4>Insérer votre code</h4>
                <div class="code">
                    <input class="chiffre" type="text" name="code1" placeholder="-">
                    <input class="chiffre" type="text" name="code2" placeholder="-">
                    <input class="chiffre" type="text" name="code3" placeholder="-">
                    <h1>-</h1>
                    <input class="chiffre" type="text" name="code4" placeholder="-">
                    <input class="chiffre" type="text" name="code5" placeholder="-">
                    <input class="chiffre" type="text" name="code6" placeholder="-">
                    <input type="text" name="secret" value="<?php echo $secret; ?>" hidden>
                </div>
                <button class="bouton" type="submit">Valider</button>
                <p style="color:red; text-align: center;" id="err" hidden></p>
            </form>
        </section>
        <a class="btnJaune" href="A2F-pres.php">Retour</a>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="script/inputs.js"></script>
    <script>

        function getCookie(nomCookie) {
            // Récupère tous les cookies et les sépare en un tableau
            const cookies = document.cookie.split('; ');
            // Trouve le cookie qui commence par le nom spécifié et retourne sa valeur
            const value = cookies.find(c => c.startsWith(nomCookie + "="))?.split('=')[1];
            if (value === undefined) {
                return null
            } 
            console.log(value);
            return decodeURIComponent(value);
        }

        const email = getCookie('email');
        const secret = <?php echo json_encode($secret); ?>;
        const err = document.getElementById('err');

        // Lorsque formulaire envoyé
        document.getElementById('otpForm').addEventListener('submit', function (e){
            e.preventDefault();
            //Création requète
            var reqHTTP = new XMLHttpRequest();
            reqHTTP.onreadystatechange = function(){
                //retour
                console.log(this);
                //Si la requète OK (200 = tout bien passé)
                if(this.readyState == 4 && this.status == 200){
                    console.log(this.response)
                }else if(this.readyState==4){ // Si erreur
                    alert("Erreur lors de la validation du code !");
                    err.removeAttribute("hidden");
                    err.innerText = "Code incorrect";
                }
            };
            //Si OTP à 6 chiffre
            if(checkOTP()!==-1){
                let repopt = checkOTP(); // return otpstr
                reqHTTP.open("GET", "/backend/A2F-test.php?email=" + email +"&secret=" + secret + "&otp=" + repopt)
                reqHTTP.send()
                reqHTTP.onload = function() {
                    if (this.status == 200) {
                        if(this.responseText === "Code correct"){
                            window.location.href = "A2F-conf.php";
                        }
                    }
                };
                err.setAttribute('hidden', '');
            }
            return false;
        });
    </script>
</body>

</html>