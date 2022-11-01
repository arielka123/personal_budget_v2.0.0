let expenseCategoryMenu = document.querySelector('#expenseCategoryMenu');
let expenseCategoryIcon = document.querySelector('#expenseCategoryIcon');
let expenseCategory = document.querySelector('#expenseCategory');

function  showExpenseCategory() {
    
    if (expenseCategory.style.display === "none") {

        expenseCategory.style.display = "block";
 
        incomes.style.display = "none";

    } 
    else {
        
        expenseCategory.style.display = "none";
    }
}


expenseCategoryMenu.addEventListener('click', showExpenseCategory);
