
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
        const res = await fetch(`../api/expenseCategoriesName/${category}`);
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

async function addLimit (category, amount){
        const limitInfo = await getLimitForCategory(category);
       
        // console.log({limitInfo});
        // console.log(Object.values({limitInfo}));

        let array = Object.values({limitInfo});
        let limit = array[0]; 

        showInfoBox(limit);
        showNewExpenseBox(limit, amount);

        const expensesInfo = await getMonthlyExpensesForCategory(category);
        let array2 = Object.values({expensesInfo});
        let expenses = array2[0]; 
    
        showExpensesBox(expenses);
        showDifferenceBox(limit, expenses);
        showInfo();
}


//eventListener

 expenseCategoryArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    let amount = amountArea.value;

    addLimit(category, amount);
 });

 amountArea.addEventListener('input', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    let amount = amountArea.value; 

    addLimit(category, amount);

 });

 dateArea.addEventListener('change', () => {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    const date = dateArea.value;
    let amount = amountArea.value;

    addLimit(category, amount);
 });


 //render to DOM

function showInfoBox(limit){

    if(isNaN(limit)) limit=0;
    limitBox.innerText = `Limit: ${limit} PLN`  
 }

function showNewExpenseBox(limit, amount){
  
    let limitFloat = parseFloat(limit);
    let amountFloat = parseFloat(amount);

    if(isNaN(amountFloat) || amountFloat<0) amountFloat=0;
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
        document.getElementById("infoText").style.color  = "#4db6ac";
    }
    else{
        infoText.innerText = 
        `Informacje o limicie: Przekroczyłeś limit o ${-difference} złotych w wybranej kategorii`;
        
        document.getElementById("infoText").style.color  = "#e60e07";
    }
}

function showDifferenceBox(limit, expenses){
    
    let limitFloat = parseFloat(limit);
    let expensesFloat = parseFloat(expenses);
    if(isNaN(limitFloat)) limitFloat=0;
    if(isNaN(expensesFloat)) expensesFloat=0;

    let difference =0;
    difference =  limitFloat - expensesFloat;

    let difference2 = Number((difference).toFixed(2));
    if(isNaN(difference2)) difference2=0;

    differenceBox.innerText = `Różnica: ${difference2} PLN`;

    showInfoText(difference2);
 }

 //#TODO wyciagnij name for category




    