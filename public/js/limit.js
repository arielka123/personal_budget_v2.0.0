fetch("/api/expenses")
    .then((response) => response.json())
    .then((data) => console.log(data));


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
    fetch(`/api/limit/:${id}`);
}

const checkLimit = () =>{
    getSumExpensesForSelectedMonth();
    calculateLimits();
    renderOnDom();
}

