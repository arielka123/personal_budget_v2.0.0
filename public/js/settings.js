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
        expenseCategoryIcon.classList.remove("icon-down-dir");
        expenseCategoryIcon.classList.add("icon-up-dir");

    } 
    else {
        
        expenseCategory.style.display = "none";
        expenseCategoryIcon.classList.add("icon-down-dir");
        expenseCategoryIcon.classList.remove("icon-up-dir");
    }
}

function  showIncomeCategory() {
    
    if (incomeCategory.style.display === "none") {

        incomeCategory.style.display = "block";
        incomeCategoryIcon.classList.remove("icon-down-dir");
        incomeCategoryIcon.classList.add("icon-up-dir");
 
    } 
    else {
        
        incomeCategory.style.display = "none";
        incomeCategoryIcon.classList.add("icon-down-dir");
        incomeCategoryIcon.classList.remove("icon-up-dir");
    }
}

function  showPayments() {
    
    if (payments.style.display === "none") {

        payments.style.display = "block";
        paymentsIcon.classList.remove("icon-down-dir");
        paymentsIcon.classList.add("icon-up-dir");
 
    } 
    else {
        payments.style.display = "none";
        paymentsIcon.classList.add("icon-down-dir");
        paymentsIcon.classList.remove("icon-up-dir");
    }
}

function  showProfile() {
    
    if (profile.style.display === "none") {

        profile.style.display = "block";
        profileIcon.classList.remove("icon-down-dir");
        profileIcon.classList.add("icon-up-dir");
 
    } 
    else {
        profile.style.display = "none";
        profileIcon.classList.add("icon-down-dir");
        profileIcon.classList.remove("icon-up-dir");
    }
}

expenseCategoryMenu.addEventListener('click', showExpenseCategory);
incomeCategoryMenu.addEventListener('click', showIncomeCategory);
paymentsMenu.addEventListener('click', showPayments);
profileMenu.addEventListener('click', showProfile);
