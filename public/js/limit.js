
// obszar w DOM

const expenseCategoryArea = document.querySelector('#expense');
const amountArea = document.querySelector('#amount');
const dateArea = document.querySelector('#today');

const infoText = document.querySelector('#infoText');

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

//action

async function addLimit (category, date, amount){
        const limitInfo = await getLimitForCategory(category);
       
        // console.log({limitInfo});
        // console.log(Object.values({limitInfo}));

        let array = Object.values({limitInfo});
        let limit = array[0]; 

        // let limit = parseFloat(value);

        showInfoBox(limit);
        showNewExpenseBox(limit, amount);

        const expensesInfo = await getMonthlyExpensesForCategory(category);
        let array2 = Object.values({expensesInfo});
        let expenses = array2[0]; 
    
        showExpensesBox(expenses);
        showDifferenceBox(limit, expenses)
}

//eventListener

 expenseCategoryArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    const amount = amountArea.value;

    addLimit(category, date, amount);
 });

 amountArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    const amountString = amountArea.value;
    const amount = parseFloat(amountString);

    addLimit(category, date, amount);

 });

 dateArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    const amount = amountArea.value;

    addLimit(category, date, amount);
 });


 //render to DOM

function showInfoBox(limit){
    limitBox.innerText = `Limit: ${limit} PLN`  
 }

function showNewExpenseBox(limit, amount){
  
    let limitFloat = parseFloat(limit);
    let amountFloat = parseFloat(amount);

    if(isNaN(amountFloat)) amountFloat=0;
    if(isNaN(limitFloat)) limitFloat=0;

    let newAmount = limitFloat + amountFloat;
    newExpenseBox.innerText = `Wydatki + wpisana kwota: ${newAmount} PLN` 
 }

function showExpensesBox(expenses){
    
    let expensesFloat = parseFloat(expenses);
    if(isNaN(expensesFloat)) expensesFloat=0;
    expenseBox.innerText = `Wydano: ${expensesFloat} PLN`;
 }

function showInfoText(difference){

    if(difference>=0){
        infoText.innerText = 
        `Informacje o limicie: Możesz jeszcze wydać ${difference} złotych w wybranej kategorii`;
    }
    else{
        infoText.innerText = 
        `Informacje o limicie: Przekroczyłeś limit o ${-difference} złotych w wybranej kategorii`;
    }

}
function showDifferenceBox(limit, expenses){
    
    let limitFloat = parseFloat(limit);
    let expensesFloat = parseFloat(expenses);
    if(isNaN(limitFloat)) limitFloat=0;
    if(isNaN(expensesFloat)) expensesFloat=0;

    let difference = limitFloat - expensesFloat;
    let differenceFloat = parseFloat(difference);

    if(isNaN(differenceFloat)) differenceFloat=0;

    differenceBox.innerText = `Różnica: ${differenceFloat} PLN`;

    showInfoText(difference);
 }

//#TODO wyświetl limit dla danej kategorii na stronie 

 //#TODO wyciagnij name for category




    