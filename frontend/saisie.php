<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification A2F</title>
    <link rel="stylesheet" href="verification.css">
    <script src="verification.js" defer></script>
</head>
<body>
    <header></header>
    <main>
        <div class="box">
            <h2>Saisir le code PIN</h2>
            
            <span id="err" hidden>Erreur lors de la connexion</span>
            <span id="success" hidden>Connexion réussite</span>
            
            <input id="hidden-input" type="tel" maxlength="6" autocomplete="one-time-code" inputmode="numeric">
            <div id="pin">
                
                <div class="nombre-box">
                    <div class="nombre-display" data-index="0">
                        <div class="point"></div>
                        <div class="char"></div>
                    </div>
                </div>
                <div class="nombre-box">
                    <div class="nombre-display" data-index="1">
                        <div class="point"></div>
                        <div class="char"></div>
                    </div>
                </div>
                <div class="nombre-box">
                    <div class="nombre-display" data-index="2">
                        <div class="point"></div>
                        <div class="char"></div>
                    </div>
                </div>
                <p>-</p>
                  <div class="nombre-box">
                    <div class="nombre-display" data-index="3">
                        <div class="point"></div>
                        <div class="char"></div>
                    </div>
                </div>
                <div class="nombre-box">
                    <div class="nombre-display" data-index="4">
                        <div class="point"></div>
                        <div class="char"></div>
                    </div>
                </div>
                <div class="nombre-box">
                    <div class="nombre-display" data-index="5">
                        <div class="point"></div>
                        <div class="char"></div>
                    </div>
                </div>

            </div>
             <button type="button" value="" class="btn-sub" onclick="checkValid('yoyo@gmail.com')">Valider</button>
             <button type="button" value="" class="btn-sub" onclick="clearPin()">Effacer</button>

        </div>
    </main>
</body>
</html>