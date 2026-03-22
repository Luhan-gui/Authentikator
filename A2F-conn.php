<!-- 
    Fichier : A2F-conn.php
    Description : Page de connexion de l'authentification à deux facteurs (A2F) pour les utilisateurs d'Alizon, 
                permettant aux utilisateurs de saisir le code OTP généré par leur application d'authentification 
                afin de vérifier leur identité et de les connecter sur leur compte. Cette page envoie le traitement 
                du code OTP au backend pour validation et redirige les utilisateurs vers la page de confirmation en cas de succès.
    Auteur : SkibidiCorp - Luhan
    Date de création : 16/03/2026
    Libraries utilisées : OTPHP (pour la génération de TOTP)
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2F - Connexion</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <main>
        <img class="logo" src="img/logo_alizon_front.svg" alt="Logo Alizon">
        <section class="container">
            <form id="otpForm">
                <h4>Insérer votre code OTP</h4>
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
        <a class="btnJaune" href="A2F-conf.php">Retour</a>
    </main>
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
                reqHTTP.open("GET", "/backend/A2F-testCon.php?email=" + email + "&otp=" + repopt)
                reqHTTP.send()
                reqHTTP.onload = function() {
                    if (this.status == 200) {
                        if(this.responseText === "Code correct"){
                            window.location.href = "A2F-fin.php";
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