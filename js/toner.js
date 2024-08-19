fetch('tonerDisplay.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#tonerTable tbody');
    
            data.forEach(row => {
                const newRow = tableBody.insertRow();

                // newRow.insertCell().innerHTML = '<td><a href="edit_row.php?name=' + row.user_name + '&row='+ row.project_id + '"><i class="bx bx-edit-alt" ></i></a></td>';
                
                newRow.insertCell().textContent = row.TonerName;
                newRow.insertCell().textContent = row.TonerQuantity;
                newRow.insertCell().innerHTML = '<td><a href="delete_row.php?name=' + row.TonerName + '&row='+ row.Toner_id + '"><i class="bx bx-trash" ></i></a></td>';

            });
        })
        .catch(error => console.error('Error fetching data:', error));