// Récupère tous les champs .code et les convertit en tableau
const inputs = Array.from(document.querySelectorAll('.code .chiffre'));
const len = inputs.length;

// Pour les 6 champs,
inputs.forEach((input, i) => {
    // Limite à 1 caractère et force le clavier chiffre sur mobile
    input.setAttribute('maxlength', '1');
    input.setAttribute('inputmode', 'numeric');

    // Fonction utilitaire pour placer le focus sur l'index demandé (saturé à la fin)
    const focusNext = (idx) => {
        const next = Math.min(idx, len - 1);
        inputs[next].focus();
    };

    // Lorsqu'un utilisateur saisit quelque chose dans l'input
    input.addEventListener('input', (e) => {
        // garde que les chiffres
        let v = (input.value || '').replace(/\D/g, '');

        if (v.length === 1) {
            // Saisie d'un seul chiffre puis passe au champ suivant
            input.value = v;
            if (i < len - 1) inputs[i + 1].focus();
            return;
        }

        // Si plusieurs chiffres collés/saisis (coller d'un code entier), on répartit
        for (let k = 0; k < v.length && (i + k) < len; k++) {
            inputs[i + k].value = v.charAt(k);
        }
        const nextIndex = i + v.length;
        if (nextIndex < len) focusNext(nextIndex);
        else inputs[len - 1].focus();
    });

    // Gestion des touches (retour arrière, blocage des caractères non numériques)
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace') {
            e.preventDefault();
            if (input.value === '') {
                // Si champ vide, on efface et retourne sur le champ précédent
                if (i > 0) {
                    inputs[i - 1].value = '';
                    inputs[i - 1].focus();
                }
            } else {
                // Sinon, on efface simplement la valeur du champ
                input.value = '';
            }
            return;
        }
        // Bloque les touches non numériques
        if (e.key.length === 1 && !/\d/.test(e.key)) {
            e.preventDefault();
        }
    });
});


function clearPin() {
    inputs.forEach(i => i.value = '');
    if (inputs.length) inputs[0].focus();
}

function checkOTP() {
    // Récupère les 6 champs et construit une chaîne
    const digitInputs = Array.from(document.querySelectorAll('.code .chiffre'));
    const otpStr = digitInputs.map(i => (i.value || '')).join('');

    // Valide la longueur
    if (otpStr.length !== 6) {
        err.removeAttribute("hidden");
        err.textContent = "Veuillez saisir les 6 chiffres";
        return -1;
    } else {
        return otpStr;
    }
}