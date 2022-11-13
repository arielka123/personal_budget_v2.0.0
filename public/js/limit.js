const getAllExpenseCategories = async () => {
// fetch("api/expenseCategories")
//     .then((response) => response.json())
//     .then((data) => console.log(data));

    const res = await fetch("api/expenseCategories");
    const data = await res.json();
    // console.log(data);
    return data;
}

const categoriesPromise = getAllExpenseCategories();
console.log(categoriesPromise);

async function fetchDataFromPromise() {
    let promise_contents = ''
    await Promise.resolve(categoriesPromise).then(value=>{
        console.log('value', value);
        promise_contents = value;
        });
    return promise_contents;
}

// let resultFromPromise = await fetchDataFromPromise().then(data => console.log(data)); 

const categoriesObiect = async () =>{
    const result = await fetchDataFromPromise();
    for (let r of result){
        console.log(r);
        console.log(r.id);
        console.log(r.name);

        // for(let x of r)
        // {
        //     console.log(x);

        // }
        // console.log(r.id);
    }
} 
categoriesObiect();
    
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

