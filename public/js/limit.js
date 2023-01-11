// obszar w DOM

const expenseCategoryArea = document.querySelector('#expense');
const amountArea = document.querySelector('#amount');
const dateArea = document.querySelector('#today');

const infoText = document.querySelector('#infoText');
const infoBox = document.querySelector('#infoBox');

const limitBox = document.querySelector('#limitBox');
const expenseBox = document.querySelector('#expenseBox');
const differenceBox = document.querySelector('#diffrenceBox');
const newExpenseBox = document.querySelector('#newExpenseBox');

//get limit from API

const getLimitForCategory = async (category) => {
    try{
        const res = await fetch(`../api/limit/${category}`);
        const data = await res.json();
        return data;
    }
    catch(e){
        console.log("ERROR", e);
    }
}

const getMonthlyExpensesForCategory = async (category) => {
    try{
        const res = await fetch(`../api/expenses/${category}`);
        const data = await res.json();
        return data;
    }
    catch(e){
        console.log("ERROR", e);
    }
}

//show 

function  showInfo() {

        infoText.classList.remove('d-none');
        infoText.classList.add('d-block');

        infoBox.classList.remove('d-none'); 
        infoBox.classList.add('d-block');    
    } 

//action

async function getData (category, amount){
        const limitInfo = await getLimitForCategory(category);
       
        // console.log({limitInfo});
        // console.log(Object.values({limitInfo}));

        let array = Object.values({limitInfo});
        let limit = array[0]; 

        showInfoBox(limit);

        const expensesInfo = await getMonthlyExpensesForCategory(category);
        let array2 = Object.values({expensesInfo});
        let expenses = array2[0]; 
    
        showExpensesBox(expenses);
        showDifferenceBox(limit, expenses);
        showNewExpenseBox(expenses, amount, limit);

        showInfo();
}

//eventListener

 expenseCategoryArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    let amount = amountArea.value;

    getData(category, amount);
 });

 amountArea.addEventListener('input', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    let amount = amountArea.value; 

    getData(category, amount);

 });

 dateArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    let amount = amountArea.value;

    getData(category, amount);
 });


 //render to DOM

function showInfoBox(limit){

    if(isNaN(limit)) limit=0;
    limitBox.innerText = `Limit: ${limit} PLN`  
 }

function showNewExpenseBox(expenses, amount, limit){
  
    let expensesFloat = parseFloat(expenses);
    let amountFloat = parseFloat(amount);
    let limitFloat = parseFloat(limit);

    if(isNaN(amountFloat) || amountFloat<0) amountFloat=0;
    if(isNaN(expensesFloat)) expensesFloat=0;

    let newAmount = expensesFloat + amountFloat;
    newExpenseBox.innerText = `Wydatki + wpisana kwota: ${newAmount} PLN` 

    changeBoxColor(limitFloat, newAmount);
 }

function showExpensesBox(expenses){
    
    let expensesFloat = parseFloat(expenses);
    if(isNaN(expensesFloat)) expensesFloat=0;
    expenseBox.innerText = `Wydano: ${expensesFloat} PLN`;
 }

 function showDifferenceBox(limit, expenses){
    
    let limitFloat = parseFloat(limit);
    let expensesFloat = parseFloat(expenses);
    if(isNaN(limitFloat)) limitFloat=0;
    if(isNaN(expensesFloat)) expensesFloat=0;

    let diff =0;
    diff = limitFloat - expensesFloat;

    let difference = Number((diff).toFixed(2));
    if(isNaN(difference)) difference=0;

    differenceBox.innerText = `Różnica: ${difference} PLN`;
    showInfoText(difference);

    if(difference>=0){
        differenceBox.classList.remove("text-danger");
        differenceBox.classList.remove("fw-bold");


    }
    else{
        differenceBox.classList.add("text-danger");
        differenceBox.classList.add("fw-bold");

    }
 }

function showInfoText(difference){

    if(difference>=0){
        infoText.innerText = 
        `Informacje o limicie: Możesz jeszcze wydać ${difference} PLN w wybranej kategorii`;
    }
    else{
        infoText.innerText = 
        `Informacje o limicie: Przekroczyłeś limit o ${-difference} złotych w wybranej kategorii`;
    }

    document.getElementById("infoText").style.color  = "#777";
    infoText.classList.add("fw-bold");
}

function changeBoxColor(limitFloat, newAmount){

    if(limitFloat>=newAmount){

        infoBox.classList.remove("bg-warning");
        infoBox.classList.add("bg-success");
        infoBox.classList.add("text-light");

    }
    else {
        infoBox.classList.remove("bg-success");
        infoBox.classList.add("bg-warning");
        infoBox.classList.remove("text-light");
    }
 }




    