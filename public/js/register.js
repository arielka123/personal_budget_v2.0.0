let w1 = document.querySelector('#expensesRegister');
let w2 = document.querySelector('#incomesRegister');
let expenses = document.querySelector('#expenses');



function  showExpenseRegister () {
    
        if (expenses.style.display === "none") {
            expenses.style.display = "block";
            w1.classList.remove('registerSelect');
            w1.classList.add('registerSelectActive');
  

        } 
        else {
            expenses.style.display = "none";
            w1.classList.remove('registerSelectActive');
            w1.classList.add('registerSelect');
        }
        
   
}

w1.addEventListener('click', showExpenseRegister);