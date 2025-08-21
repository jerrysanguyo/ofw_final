document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("needs-container");
    const addBtn = document.getElementById("add-need-row");
    const removeBtn = document.getElementById("remove-need-row");

    function getSelects() {
        return Array.from(container.querySelectorAll(".need-select"));
    }
    
    function syncOptions() {
        const selects = getSelects();
        const chosen = new Set(
            selects.map(s => s.value).filter(v => v !== "")
        );

        selects.forEach(select => {
            const myVal = select.value;
            Array.from(select.options).forEach(opt => {
                if (!opt.value) return; 
                opt.disabled = chosen.has(opt.value) && opt.value !== myVal;
            });
        });
    }
    
    function addRow() {
        const rows = container.getElementsByClassName("need-row");
        if (rows.length === 0) return;

        const newIndex = rows.length;
        const template = rows[0];
        const clone = template.cloneNode(true);
        
        const select = clone.querySelector(".need-select");
        select.id = "need_id_" + newIndex;
        
        const label = clone.querySelector("label");
        if (label) label.setAttribute("for", select.id);
        select.value = "";
        Array.from(select.options).forEach(opt => opt.disabled = false);
        select.addEventListener("change", syncOptions);

        container.appendChild(clone);
        syncOptions();
    }

    function removeRow() {
        const rows = container.getElementsByClassName("need-row");
        if (rows.length > 1) {
            container.removeChild(rows[rows.length - 1]);
            syncOptions();
        }
    }
    
    getSelects().forEach(s => s.addEventListener("change", syncOptions));
    addBtn.addEventListener("click", addRow);
    removeBtn.addEventListener("click", removeRow);
    
    syncOptions();
});