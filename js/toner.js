fetch('tonerDisplay.php')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#tonerTable tbody');

        data.forEach(row => {
            const newRow = tableBody.insertRow();

            newRow.insertCell().textContent = row.TonerName;
            newRow.insertCell().textContent = row.TonerQuantity;
            newRow.insertCell().innerHTML = '<td><a href="delete_row.php?name=' + row.TonerName + '&row='+ row.Toner_id + '"><i class="bx bx-trash" ></i></a></td>';

            newRow.addEventListener('click', () => {
                // Populate modal with toner details
                document.getElementById('tonerName').value = row.TonerName;
                document.getElementById('tonerId').value = row.Toner_id;
                $('#tonerRequestModal').modal('show');
            });
        });
    })
    .catch(error => console.error('Error fetching data:', error));

document.getElementById('submitRequest').addEventListener('click', () => {
    const form = document.getElementById('tonerRequestForm');
    const formData = new FormData(form);

    fetch('tonerRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        $('#tonerRequestModal').modal('hide');
    })
    .catch(error => console.error('Error submitting request:', error));
});
