
// obszar w DOM

const expenseCategoryArea = document.querySelector('#expense');
const amountArea = document.querySelector('#amount');
const dateArea = document.querySelector('#today');

const infoText = document.querySelector('#infoText');

const limitBox = document.querySelector('#limitBox');
const expenseBox = document.querySelector('#expenseBox');
const diffrenceBox = document.querySelector('#diffrenceBox');
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

//action

async function addLimit (category, date, amount){
        const limitInfo = await getLimitForCategory(category);
       
        // console.log({limitInfo});
        // console.log(Object.values({limitInfo}));

        let array = Object.values({limitInfo});
        let limit = array[0]; 

        // let limit = parseFloat(value);

        console.log(category);
        console.log(date);
        console.log(amount);
        console.log(limit);

        showInfoText(limit);
        showNewExpenseBox(limit, amount);
}

async function addMonthlyExpenses(category){
    const expensesInfo = await getMonthlyExpensesForCategory(category);
    let array = Object.values({expensesInfo});
    let expenses = array[0]; 

    showExpensesBox(expenses);
}

//eventListener

 expenseCategoryArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    const amount = amountArea.value;

    addLimit(category, date, amount);
    addMonthlyExpenses(category);

 });

 amountArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    const amountString = amountArea.value;
    const amount = parseFloat(amountString);

    addLimit(category, date, amount);
    addMonthlyExpenses(category);
 });

 dateArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    const amount = amountArea.value;

    addLimit(category, date, amount);
    addMonthlyExpenses(category);

 });


 //render to DOM

function showInfoText(limit){
    limitBox.innerText = `Limit: ${limit} PLN`  
 }

 function showNewExpenseBox(limit, amount){
  
    limitFloast = parseFloat(limit);
    amountFloat = parseFloat(amount);

    if(isNaN(amountFloat)) amountFloat=0;
    if(isNaN(limitFloast)) limitFloast=0;

    let newAmount = limitFloast + amountFloat;
    newExpenseBox.innerText = `Wydatki + wpisana kwota: ${newAmount} PLN` 
 }

 function showExpensesBox(expenses){
    
    expensesFloast = parseFloat(expenses);
    if(isNaN(expensesFloast)) expensesFloast=0;
    expenseBox.innerText = `Wydano: ${expensesFloast} PLN`;
 }



//#TODO wyświetl limit dla danej kategorii na stronie 

 //#TODO wyciagnij name for category




    