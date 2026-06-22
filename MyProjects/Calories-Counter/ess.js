document.addEventListener("DOMContentLoaded", () => {
    //all the HTML elements 
    const entryForm = document.getElementById("entry-form");
    const itemNameInput = document.getElementById("item-name");
    const itemCaloriesInput = document.getElementById("item-calories");
    const entryList = document.getElementById("entry-list");
    const totalCaloriesEl = document.getElementById("total-calories");

    let entries = [];

    //runs when click "Add Entry"
    entryForm.addEventListener("submit", (event) => {
       
        event.preventDefault(); 

        const name = itemNameInput.value;
        const calories = parseInt(itemCaloriesInput.value); // text to num

        if (name && !isNaN(calories)) {
            const newEntry = {          //new object
                name: name,
                calories: calories
            };
            entries.push(newEntry);
            updateDOM();                //append and show entry

            itemNameInput.value = "";
            itemCaloriesInput.value = "";
        } else {
            alert("error invalid name or calorie");
        }
    });
//________________________________________________________
    function updateDOM() {
        entryList.innerHTML = "";

        entries.forEach((entry) => {
            const li = document.createElement("li");
            li.innerHTML = `
                ${entry.name}
                <span>${entry.calories} cal</span>
            `;
            entryList.appendChild(li);
        });

        calculateTotal();
    }
//_____________________________________________________________
    function calculateTotal() {
        const total = entries.reduce((sum, currentEntry) => {
            return sum + currentEntry.calories;
        }, 0); // initalize sum = 0

        totalCaloriesEl.textContent = total;    //updaate
    }

});