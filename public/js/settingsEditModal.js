const editIncome = document.querySelectorAll('.editIncomeIcon');
const editIncCategory2 = document.querySelector('#editIncCategory2');
// const editIncCategory = document.querySelector('#editIncCategory');

const editExpense = document.querySelectorAll('.editExpenseIcon');
const editExpCategory2 = document.querySelector('#editExpenseCategory2');

const editPayments = document.querySelectorAll('.editPaymentsIcon');
const editPayCategory2 = document.querySelector('#editPaymentsCategory2');

function getIdCat(e,data){

  const elementId = e.target.id;
  const elementValue = document.getElementById(elementId).value;

  // If element has id
  if (elementId !== '') {
      data.setAttribute("value", elementId)
      console.log(elementId);
      console.log(elementValue);
    } 
}

for (x of editIncome){
    x.addEventListener('click', (e) =>
    {
        getIdCat(e, editIncCategory2);
    }
  );
}

for (x of editExpense){
    x.addEventListener('click', (e) =>
    {
        getIdCat(e, editExpCategory2);
    }
  );
}

for (x of editPayments){
    x.addEventListener('click', (e) =>
    {
        getIdCat(e, editPayCategory2);
    }
  );
}


