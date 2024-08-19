fetch('usersDisplay.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#userTable tbody');
    
            data.forEach(row => {
                const newRow = tableBody.insertRow();

                // newRow.insertCell().innerHTML = '<td><a href="edit_row.php?name=' + row.user_name + '&row='+ row.project_id + '"><i class="bx bx-edit-alt" ></i></a></td>';
                
                newRow.insertCell().textContent = row.Firstname;
                newRow.insertCell().textContent = row.Lastname;
                newRow.insertCell().textContent = row.Email;
                newRow.insertCell().innerHTML = '<td><a href="delete_user.php?name=' + row.Firstname + '&row='+ row.User_id + '"><i class="bx bx-trash" ></i></a></td>';

            });
        })
        .catch(error => console.error('Error fetching data:', error));