const expenseCategoryMenu = document.querySelector('#expenseCategoryMenu');
const expenseCategoryIcon = document.querySelector('#expenseCategoryIcon');
const expenseCategory = document.querySelector('#expenseCategory');

const incomeCategoryMenu = document.querySelector('#incomeCategoryMenu');
const incomeCategoryIcon = document.querySelector('#incomeCategoryIcon');
const incomeCategory = document.querySelector('#incomeCategory');

const paymentsMenu = document.querySelector('#paymentsMenu');
const paymentsIcon = document.querySelector('#paymentsIcon');
const payments = document.querySelector('#payments');

const profileMenu = document.querySelector('#profileMenu');
const profileIcon = document.querySelector('#profileIcon');
const profile = document.querySelector('#profile');

let expenseTrashIcon = document.querySelector('#expenseTrashIcon');
let incomeTrashIcon = document.querySelector('#incomeTrashIcon');
let paymentsTrashIcon = document.querySelector('#paymentsTrashIcon');


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


