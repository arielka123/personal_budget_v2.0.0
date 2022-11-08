let edit = document.querySelectorAll('.editIncomeIcon');
const editIncCategory2 = document.querySelector('#editIncCategory2');
const editIncCategory = document.querySelector('#editIncCategory');


for (x of edit){


    x.addEventListener('click', (e) =>
  {
    // Retrieve id from clicked element
    const elementId = e.target.id;
    const elementValue = document.getElementById(elementId).value;

   
    // If element has id
    if (elementId !== '') {

        editIncCategory2.setAttribute("value", elementId)
        console.log(elementId);
        console.log(elementValue);


    }
  }
);


}



