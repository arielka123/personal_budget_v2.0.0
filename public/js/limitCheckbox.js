const limitCheckboxEdit = document.querySelector('#limitCheckboxEdit');
const amountLimitEdit = document.querySelector('#amountLimitEdit');

const limitCheckboxAdd = document.querySelector('#limitCheckboxAdd');
const amountLimitAdd = document.querySelector('#amountLimitAdd');


function amountInputE(){

  if (limitCheckboxEdit.checked === true){
    amountLimitEdit.disabled = false;
  }  
  else {
    amountLimitEdit.disabled = true;
    amountLimitEdit.value = '';
  }
}

function amountInputA(){

    if (limitCheckboxAdd.checked === true){
        amountLimitAdd.disabled = false;
    }  
    else {
        amountLimitAdd.disabled = true;
        amountLimitAdd.value = '';
    }
  }

limitCheckboxEdit.addEventListener('click', amountInputE);
limitCheckboxAdd.addEventListener('click', amountInputA);
