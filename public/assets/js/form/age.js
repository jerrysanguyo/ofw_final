document.addEventListener("DOMContentLoaded", function() {
    const birthdateInput = document.getElementById("birthdate");
    const ageInput = document.getElementById("age");

    function calculateAge(birthdate) {
        const today = new Date();
        const birthDate = new Date(birthdate);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age >= 0 ? age : "";
    }

    function updateAge() {
        if (birthdateInput.value) {
            ageInput.value = calculateAge(birthdateInput.value);
        } else {
            ageInput.value = "";
        }
    }

    updateAge();

    birthdateInput.addEventListener("input", updateAge);
});
