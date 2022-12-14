
const expenseCategoryArea = document.querySelector('#expense');

let expenseSelectedID = function () {
    console.log(expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id);
  };
  
let category = expenseCategoryArea.addEventListener('change', expenseSelectedID);

const getLimitForCategory = async (category) => {

    try{
        const res = await fetch(`../api/limit/${category}`);
        const data = await res.json();
        return data;
    }
    catch(e){
        console.log('ERROR',e);
    }
}

//#TODO wyciagnij id kategorii po kliknieciu na stronie

    
    // REST API

const renderOnDom = () =>{
    //if necessary
};

const calculateLimits = () =>{
    //calculate limits
}    

const getSumExpensesForSelectedMonth = () =>{
    fetch(`/api/expenses/:${id}?date=${date}`);
}

const getLimitCategory = () =>{
    fetch(`/api/expenseCategories/:${id}`);
}

const checkLimit = () =>{
    getSumExpensesForSelectedMonth();
    calculateLimits();
    renderOnDom();
}

    