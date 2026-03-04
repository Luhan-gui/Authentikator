function sendGet(url, onSuccess, onError) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (typeof onSuccess === 'function') onSuccess(xhr);
        } else {
            if (typeof onError === 'function') onError(xhr);
        }
    };
    xhr.onerror = function() {
        if (typeof onError === 'function') onError(xhr);
    };
    xhr.send();
}

const input = document.getElementById('hidden-input');
const boxes = document.querySelectorAll('.nombre-display');
const codeRow = document.getElementById('pin');
const btnSub = document.querySelectorAll("btn-sub")
const err = document.getElementById("err")
const success = document.getElementById("success")

document.querySelector('.box').addEventListener('click', () => input.focus());

function updateDisplay(value) {
    boxes.forEach((box, i) => {
      const char = box.querySelector('.char');
      const digit = value[i] || '';

      if (digit) {
        char.textContent = digit;
        box.classList.add('filled');
        box.classList.remove('active', 'error', 'success');
      } else {
        char.textContent = '';
        box.classList.remove('filled', 'error', 'success');
      }

      // Active = cursor position
      box.classList.toggle('active', i === value.length && i < 6);
    })
}
input.addEventListener('input', () => {
    // Garde seulement les nombres
    const digits = input.value.replace(/\D/g, '').slice(0, 6);
    input.value = digits;
    updateDisplay(digits);

  });

function checkValid(email){
    const pin = input.value; // Récupère la valeur de l'input
    
    if (pin.length !== 6) {
        err.removeAttribute("hidden");
        err.textContent = "Veuillez saisir les 6 chiffres";
        return;
    }
    
    url = "../backend/a2f-verif.php?email="+encodeURIComponent(email)+"&pin="+encodeURIComponent(pin)
    sendGet(url,function() { 
            // Connexion OK 
            success.removeAttribute("hidden")
            err.setAttribute("hidden", "")
        },
        function() { 
            // Erreur -> affichage du message d'erreur
            err.removeAttribute("hidden")
            err.textContent = "Erreur lors de la connexion"
            clearPin()
            success.setAttribute("hidden", "")    
        }
        );
}
function clearPin(){
    input.value = ""
    updateDisplay('')
}
updateDisplay('');
