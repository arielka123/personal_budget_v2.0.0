const edit = document.querySelector('.editIncomeIcon');
const editIncCategory = document.querySelector('#editIncCategory');



    document.addEventListener('click', (e) =>
  {
    // Retrieve id from clicked element
    let elementId = e.target.id;
   
    // If element has id
    if (elementId !== '') {
        editIncCategory.setAttribute("value", elementId )
    }
  }
);
    // editIncCategory.setAttribute("value", )


