fetch('tonerDisplay.php') 
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#tonerTable tbody');

        data.forEach(row => {
            const newRow = tableBody.insertRow();

            if(admin === "1"){
                newRow.insertCell().innerHTML = '<td><i class="bx bx-edit" style="cursor: pointer;"></i></td>';
            }
            newRow.insertCell().textContent = row.TonerName;
            newRow.insertCell().textContent = row.TonerQuantity;
            if(admin === "1"){
                newRow.insertCell().innerHTML = '<td><a href="delete_row.php?name=' + row.TonerName + '&row='+ row.Toner_id + '"><i class="bx bx-trash" ></i></a></td>';
            }

            // Attach the row ID for easy reference
            newRow.setAttribute('data-id', row.Toner_id);

            if(admin === "1"){
                newRow.cells[0].addEventListener('click', () => {
                    // Populate the modal with toner details
                    document.getElementById('editTonerId').value = row.Toner_id;
                    document.getElementById('editTonerName').value = newRow.cells[1].textContent;
                    document.getElementById('editTonerQuantity').value = newRow.cells[2].textContent;
                    $('#editTonerModal').modal('show');
                });
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));

    document.getElementById('editTonerForm').addEventListener('submit', (event) => {
        event.preventDefault();
        
        const form = document.getElementById('editTonerForm');
        const formData = new FormData(form);
        const tonerId = formData.get('tonerId');
    
        fetch('editToner.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            $('#editTonerModal').modal('hide');
            
            // Find the row in the table that corresponds to the updated toner
            const updatedRow = document.querySelector(`#tonerTable tbody tr[data-id="${tonerId}"]`);
    
            // Update the row with the new values
            updatedRow.cells[1].textContent = formData.get('tonerName');
            updatedRow.cells[2].textContent = formData.get('tonerQuantity');
        })
        .catch(error => console.error('Error updating toner:', error));
    });

