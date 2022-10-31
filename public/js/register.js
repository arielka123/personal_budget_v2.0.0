let w1 = document.querySelector('#expensesRegister');
let w2 = document.querySelector('#incomesRegister');
let expenses = document.querySelector('#expenses');
let incomes = document.querySelector('#incomes');

function  showExpenseRegister () {
    
        if (expenses.style.display === "none") {
            expenses.style.display = "block";
            w1.classList.remove('registerSelect');
            w1.classList.add('registerSelectActive');
            
            incomes.style.display = "none";
            w2.classList.add('registerSelect');
            w2.classList.remove('registerSelectActive');
        } 
        else {
            expenses.style.display = "none";
            w1.classList.remove('registerSelectActive');
            w1.classList.add('registerSelect');
        }
}

function  showIncomeRegister () {
    
    if (incomes.style.display === "none") {
        incomes.style.display = "block";

        w2.classList.remove('registerSelect');
        w2.classList.add('registerSelectActive');
       
        expenses.style.display = "none";
        w1.classList.remove('registerSelectActive');
        w1.classList.add('registerSelect');
    } 
    else {
        incomes.style.display = "none";
        w2.classList.remove('registerSelectActive');
        w2.classList.add('registerSelect');
    }
}

w1.addEventListener('click', showExpenseRegister);
w2.addEventListener('click', showIncomeRegister);