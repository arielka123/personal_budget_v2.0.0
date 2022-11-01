let expenseCategoryMenu = document.querySelector('#expenseCategoryMenu');
let expenseCategoryIcon = document.querySelector('#expenseCategoryIcon');
let expenseCategory = document.querySelector('#expenseCategory');

let incomeCategoryMenu = document.querySelector('#incomeCategoryMenu');
let incomeCategoryIcon = document.querySelector('#incomeCategoryIcon');
let incomeCategory = document.querySelector('#incomeCategory');

let paymentsMenu = document.querySelector('#paymentsMenu');
let paymentsIcon = document.querySelector('#paymentsIcon');
let payments = document.querySelector('#payments');

let profileMenu = document.querySelector('#profileMenu');
let profileIcon = document.querySelector('#profileIcon');
let profile = document.querySelector('#profile');

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

function  showPayments() {
    
    if (payments.style.display === "none") {

        payments.style.display = "block";
 
    } 
    else {
        payments.style.display = "none";
    }
}

function  showProfile() {
    
    if (profile.style.display === "none") {

        profile.style.display = "block";
 
    } 
    else {
        profile.style.display = "none";
    }
}

expenseCategoryMenu.addEventListener('click', showExpenseCategory);
incomeCategoryMenu.addEventListener('click', showIncomeCategory);
paymentsMenu.addEventListener('click', showPayments);
profileMenu.addEventListener('click', showProfile);
