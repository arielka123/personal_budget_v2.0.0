const editIncome = document.querySelectorAll('.editIncomeIcon');
const editIncCategory2 = document.querySelector('#editIncCategory2');
const editIncCategory = document.querySelector('#editIncCategory');

const editExpense = document.querySelectorAll('.editExpenseIcon');
const editExpCategory2 = document.querySelector('#editExpenseCategory2');
const editExpCategory = document.querySelector('#editExpenseCategory');


const editPayments = document.querySelectorAll('.editPaymentsIcon');
const editPayCategory2 = document.querySelector('#editPaymentsCategory2');
const editPayCategory = document.querySelector('#editPaymentsCategory');

const limitCheckbox = document.querySelector('#limitCheckbox');
const amountLimit = document.querySelector('#amountLimitEdit');

function getIdCat(e,data){
  const elementId = e.target.id;
  const elementValue = document.getElementById(elementId).value;

  // If element has id set value to show modal 
  if (elementId !== '') {
      data.setAttribute("value", elementId)
      console.log(elementId);
      console.log(elementValue);
    } 
}

// off or on limit input
function amountInput(){

  if (document.getElementById("limitCheckbox").checked === true){
    amountLimit.disabled = false;
  }  
  else {
    amountLimit.disabled = true;
    amountLimit.value = '';
  }
}

//set category name in unput in modal
//expense
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

async function actionExpenseName(e){
  const category = e.target.id;
  const expName = await getExpenseName(category);

  let array = Object.values({expName});
  let expenseName = array[0]; 

  renderExpenseName(expenseName);
}

function renderExpenseName(expenseName){
  document.getElementById("editExpenseCategory").value = expenseName;
}

//income
const getIncomeName = async (category) => {
  try{
      const res = await fetch(`../api/incomeCategoriesName/${category}`);
      const data = await res.json();
      return data;
  }
  catch(e){
      console.log("ERROR", e);
  }
}

async function actionIncomeName(e){
  const category = e.target.id;
  const incName = await getIncomeName(category);

  let array = Object.values({incName});
  let incomeName = array[0]; 

  renderIncomeName(incomeName);
}

function renderExpenseName(expenseName){
  document.getElementById("editExpenseCategory").value = expenseName;
}

function renderIncomeName(incomeName){
  document.getElementById("editIncCategory").value = incomeName;
}

//payment
const getPaymentName = async (category) => {
  try{
      const res = await fetch(`../api/paymentsName/${category}`);
      const data = await res.json();
      return data;
  }
  catch(e){
      console.log("ERROR", e);
  }
}

async function actionPaymentName(e){
  const category = e.target.id;
  const payName = await getPaymentName(category);

  let array = Object.values({payName});
  let paymentName = array[0]; 

  renderPaymentName(paymentName);
}

function renderPaymentName(paymentName){
  document.getElementById("editPaymentsCategory").value = paymentName;
}


//eventListener

for (x of editIncome){
    x.addEventListener('click', (e) =>
    {
        getIdCat(e, editIncCategory2);
        actionIncomeName(e);
    }
  );
}

for (x of editExpense){
    x.addEventListener('click', (e) =>
    {
        getIdCat(e, editExpCategory2);
        actionExpenseName(e);
    }
  );
}

for (x of editPayments){
    x.addEventListener('click', (e) =>
    {
        getIdCat(e, editPayCategory2);
        actionPaymentName (e)
    }
  );
}

limitCheckbox.addEventListener('click', amountInput);




