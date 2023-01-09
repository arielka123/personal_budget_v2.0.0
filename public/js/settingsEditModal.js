const editIncome = document.querySelectorAll('.editIncomeIcon');
const editIncCategory2 = document.querySelector('#editIncCategory2');
const editIncCategory = document.querySelector('#editIncCategory');

const editExpense = document.querySelectorAll('.editExpenseIcon');
const editExpCategory2 = document.querySelector('#editExpenseCategory2');
const editExpCategory = document.querySelector('#editExpenseCategory');


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

const getExpenseName = async (category) => {
  try{
      const res = await fetch(`../api/expenseCategoriesName/${category}`);
      const data = await res.json();
      return data;
  }
  catch(e){
      console.log("ERROR", e);
  }
}

async function action (e){
  const category = e.target.id;
  const expName = await getExpenseName(category);

  let array = Object.values({expName});
  let expenseName = array[0]; 

  renderName(expenseName);
}

function renderName(expenseName){

  document.getElementById("editExpenseCategory").value = expenseName;
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
        action(e);
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

const limitCheckbox = document.querySelector('#limitCheckbox');
const amountLimit = document.querySelector('#amountLimitEdit');


function amountInput(){

  if (document.getElementById("limitCheckbox").checked === true){
    amountLimit.disabled = false;
  }  
  else {
    amountLimit.disabled = true;
    amountLimit.value = '';
  }
}

limitCheckbox.addEventListener('click', amountInput);




