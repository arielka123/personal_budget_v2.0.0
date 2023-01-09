const amountInput = document.querySelector('#amount');
const result=  document.createElement('h6');

amountInput.addEventListener('change', () => {

    const amount = amountInput.value;
    validate(amount);
 });

 function validate(amount){

    let text ="";

    amountFloat = parseFloat(amount);
    if (amountFloat>0) text="";
    else if(isNaN(amountFloat)) text="Wprowadź kwotę"
    else if(amountFloat === 0) text="Wprowadź poprawną kwotę";
    else if (amountFloat < 0) text ="Wprowadź poprawną kwotę";

    renderInfo(text);
 }

 function renderInfo(text){

    result.innerText = "";
    result.innerText = text;
    if(text !==""){
        amountInput.insertAdjacentElement('afterend', result).style.color  = "#e60e07";
    }
 }

// jesli równe puste lub  0

// jesli nie jest liczba
// jesli ujemne

