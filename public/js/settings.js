let expenseCategoryMenu = document.querySelector('#expenseCategoryMenu');
let expenseCategoryIcon = document.querySelector('#expenseCategoryIcon');
let expenseCategory = document.querySelector('#expenseCategory');

let incomeCategoryMenu = document.querySelector('#incomeCategoryMenu');
let incomeCategoryIcon = document.querySelector('#incomeCategoryIcon');
let incomeCategory = document.querySelector('#incomeCategory');

function  showExpenseCategory() {
    
    if (expenseCategory.style.display === "none") {

        expenseCategory.style.display = "block";
 
    } 
    else {
        
        expenseCategory.style.display = "none";
    }
}

function  showIncomeCategory() {
    
    if (incomeCategory.style.display === "none") {

        incomeCategory.style.display = "block";
 
    } 
    else {
        
        incomeCategory.style.display = "none";
    }
}


expenseCategoryMenu.addEventListener('click', showExpenseCategory);
incomeCategoryMenu.addEventListener('click', showIncomeCategory);
