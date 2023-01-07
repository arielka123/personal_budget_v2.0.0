
const expenseCategoryArea = document.querySelector('#expense');

// miejsce w DOM


const getLimitForCategory = async (category) => {
    try{
        const res = await fetch(`../api/limit/${category}`);
        const data = await res.json();
        return data;
    }
    catch(e){
        console.log("ERROR", e);
    }
}


async function addLimit (category){
        const limitInfo = await getLimitForCategory(category);
       
        // console.log({limitInfo});
        // console.log(Object.values({limitInfo}));

        let array = Object.values({limitInfo});
        let value = array[0]; 
        let stringToFloat = parseFloat(value);
        console.log(stringToFloat);
    return stringToFloat;
}


let expenseSelectedID = function () {
    const category = expenseCategoryArea.options[expenseCategoryArea.selectedIndex].id;
    console.log(category);
    addLimit(category);
  };

 expenseCategoryArea.addEventListener('change', expenseSelectedID);


//#TODO wyświetl limit dla danej kategorii na stronie 

 



    