document.getElementById('leadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const preload = document.getElementById("preload");
    const formMessage = document.getElementById("formMessage");

    formMessage.classList.add("hidden");

    const inputs = document.querySelectorAll('#leadForm input');
    inputs.forEach(input => {
        input.classList.remove('border-red-500');
    });

    let isValid = true;
    const firstName = document.getElementById('firstname');
    const lastName = document.getElementById('lastname');
    const phone = document.getElementById('phone');
    const email = document.getElementById('email');

    if (firstName.value.trim() === '') {
        firstName.classList.add('border-red-500');
        isValid = false;
    }

    if (lastName.value.trim() === '') {
        lastName.classList.add('border-red-500');
        isValid = false;
    }

    const phonePattern = /^[0-9\-\+]{9,15}$/;
    if (!phonePattern.test(phone.value.trim())) {
        phone.classList.add('border-red-500');
        isValid = false;
    }

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email.value.trim())) {
        email.classList.add('border-red-500');
        isValid = false;
    }

    if (isValid) {
        preload.classList.remove("hidden");

        const data = {
            action: "createLead",
            firstName: firstName.value,
            lastName: lastName.value,
            phone: phone.value,
            email: email.value
        }
        fetch("../process/processLead.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
            .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
            })
            .then(data => {
                preload.classList.add("hidden");
                formMessage.classList.remove("hidden");
                formMessage.textContent = data.message
            })
            .catch(error => {
                preload.classList.add("hidden");
                console.error('Error:', error);
            });
    }})
