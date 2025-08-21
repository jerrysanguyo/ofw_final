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

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("household-container");

    function calculateAge(birthdateStr) {
        if (!birthdateStr) return "";
        const today = new Date();
        const birth = new Date(birthdateStr);
        
        if (isNaN(birth.getTime()) || birth > today) return "";

        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        return age >= 0 ? age : "";
    }
  
    container.addEventListener("input", function (e) {
        if (!e.target.matches(".birthdate-input")) return;

        const row = e.target.closest(".household-row") || e.target.parentElement;
        const ageInput = row.querySelector(".age-input");
        if (!ageInput) return;

        ageInput.value = calculateAge(e.target.value);
    });
  
    function initCompute() {
        container.querySelectorAll(".household-row").forEach(row => {
        const birthInput = row.querySelector(".birthdate-input");
        const ageInput = row.querySelector(".age-input");
        if (birthInput && ageInput) {
            ageInput.value = calculateAge(birthInput.value);
        }
        });
    }

    initCompute();
});