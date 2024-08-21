fetch('getTonerRequests.php')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('requestsContainer');

        data.forEach(request => {
            const card = document.createElement('div');
            card.classList.add('card');

            card.innerHTML = `
                <div class="card-header">
                    Request ID: ${request.Request_id}
                </div>
                <div class="card-body">
                    <div>
                        <h5 class="card-title">${request.TonerName}</h5>
                        <p class="card-text">Requested Quantity: ${request.RequestQuantity}</p>
                        <p class="card-text">Requested By: ${request.userEmail}</p>
                        <p class="card-text"><small class="text-muted">Requested on: ${new Date(request.RequestDate).toLocaleString()}</small></p>
                    </div>
                    <div>
                        <button class="btn btn-approve" onclick="approveRequest(${request.Request_id})"><i class="bx bx-check"></i> Approve</button>
                        <button class="btn btn-reject ml-2" onclick="rejectRequest(${request.Request_id})"><i class="bx bx-x"></i> Reject</button>
                    </div>
                </div>
            `;

            container.appendChild(card);
        });
    })
    .catch(error => console.error('Error fetching toner requests:', error));

function approveRequest(requestId) {
    // Handle approve request (e.g., send POST request to approve request)
    fetch(`approveRequest.php?requestId=${requestId}`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Request approved!');
                location.reload(); // Reload the page to reflect changes
            }
        })
        .catch(error => console.error('Error approving request:', error));
}

function rejectRequest(requestId) {
    // Handle reject request (e.g., send POST request to reject request)
    fetch(`rejectRequest.php?requestId=${requestId}`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Request rejected!');
                location.reload(); // Reload the page to reflect changes
            }
        })
        .catch(error => console.error('Error rejecting request:', error));
}
