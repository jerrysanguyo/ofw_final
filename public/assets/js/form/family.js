document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("household-container");
    const addBtn = document.getElementById("add-household-row");
    const removeBtn = document.getElementById("remove-household-row");

    addBtn.addEventListener("click", function() {
        const rows = container.getElementsByClassName("household-row");
        if (rows.length > 0) {
            const lastRow = rows[rows.length - 1];
            const newRow = lastRow.cloneNode(true); 
            
            newRow.querySelectorAll("input, select").forEach(el => {
                if (el.tagName === "INPUT") {
                    if (el.type === "number" && el.name.includes("monthly_income")) {
                        el.value = 0;
                    } else {
                        el.value = "";
                    }
                }
                if (el.tagName === "SELECT") {
                    el.selectedIndex = 0;
                }
            });
            container.appendChild(newRow);
        }
    });
    
    removeBtn.addEventListener("click", function() {
        const rows = container.getElementsByClassName("household-row");
        if (rows.length > 1) {
            container.removeChild(rows[rows.length - 1]);
        }
    });
});