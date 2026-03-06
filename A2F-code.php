<?php
    session_start();

    require_once __DIR__ . '/vendor/autoload.php';

    use OTPHP\TOTP;
    use OTPHP\InternalClock;

    $clock = new InternalClock();

    $_SESSION['email'] = "luhan@gmail.com";
    $email = $_SESSION['email'];
    $totp = TOTP::generate($clock);
    $totp = $totp->withLabel($email);
    require_once('_env.php');
    loadEnv('.env');
    //if (!isset($_SESSION['user_id'])) {
    //    header('Location: login.php');
    //    exit();
    //}
    
    
    //Récupérer les variables
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
    $req = $bdd->prepare('SELECT secret FROM information WHERE email = :email');
    $req->execute(['email' => $email]);
    
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
            <h4> Voici votre clé secrète : <?php echo $totp->getSecret(); ?></h4>
            <img class="QR"src="img/qr.png" alt="QR Code Alizon">
            <p> Veuillez entrer cette clé dans votre application d'authentification pour générer les codes de vérification à six chiffres nécessaires pour l'authentification à deux facteurs (A2F). Assurez-vous de conserver cette clé en lieu sûr, car elle est essentielle pour configurer votre compte Alizon avec l'application d'authentification. En cas de perte de cette clé, vous pourriez rencontrer des difficultés pour accéder à votre compte Alizon via l'A2F. </p>
            <p>Lorque vous avez entré la clé dans votre application d'authentification, veuillez rentrer votre code de vérification à six chiffres ci-dessous pour finaliser l'activation de l'authentification à deux facteurs (A2F) de votre compte Alizon.</p>
                <form action="A2F-code.php" method="post">
                    <h4>Insérer votre code</h4>
                    <div class="code">
                        <input class="chiffre" type="text" name="code1" placeholder="-">
                        <input class="chiffre" type="text" name="code2" placeholder="-">
                        <input class="chiffre" type="text" name="code3" placeholder="-">
                        <h1>-</h1>
                        <input class="chiffre" type="text" name="code4" placeholder="-">
                        <input class="chiffre" type="text" name="code5" placeholder="-">
                        <input class="chiffre" type="text" name="code6" placeholder="-">
                    </div>
                    <button class="bouton" type="submit">Valider</button>
                </form>
        </section>
        <a class="btnJaune" href="">Retour</a>
    </main>
    <?php include 'includes/footer.php';?>
</body>
</html>