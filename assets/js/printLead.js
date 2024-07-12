const tbody = document.getElementById("tbody");
const filterForm = document.getElementById("filterForm");
const dateFrom = document.getElementById("date_from");
const dateTo = document.getElementById("date_to");

filterForm.addEventListener("submit", (event)=>{
    event.preventDefault();

    const data = {
        action: "printLead",
        dateFrom: dateFrom.value,
        dateTo: dateTo.value
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
            console.log(data)
            tbody.innerHTML = data.data;

        })
        .catch(error => {
            console.error('Error:', error);
        });
})
