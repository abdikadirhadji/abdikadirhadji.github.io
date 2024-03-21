<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Filter Example</title>
   <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Container for the filter form */
.filter-container {
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    margin: 20px auto;
    max-width: 600px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Style for the form itself */
#filterForm {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

/* Style for input fields */
#filterForm input[type="text"],
#filterForm input[type="date"] {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: calc(50% - 12px); /* Subtracting the padding and border */
}

/* Style for input fields on focus */
#filterForm input[type="text"]:focus,
#filterForm input[type="date"]:focus {
    border-color: #7da2a9;
    outline: none;
}

/* Style for the search button */
#filterForm button {
    padding: 10px 20px;
    background-color: #5cb85c; /* A green shade */
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Change background color slightly on hover to give feedback */
#filterForm button:hover {
    background-color: #4cae4c;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    #filterForm input[type="text"],
    #filterForm input[type="date"] {
        width: 100%;
    }

    #filterForm button {
        width: 100%;
        margin-top: 10px; /* Add space between the last input and button */
    }
}

/* Table container styling */
.table-container {
    margin: 20px auto;
    max-width: 800px;
    padding: 20px;
    /* Add more styles when you have your table */

//search css 

/* Additional CSS for table styling */
.search-results-table 
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px; /* Add some space between the form and the table */
}

.search-results-table th,
.search-results-table td {
    border: 1px solid #ddd; /* Add a border to each cell */
    padding: 8px;
    text-align: left;
}

.search-results-table th {
    background-color: #4CAF50; /* A darker green for headers */
    color: white;
}

.search-results-table tr:nth-child(even) {
    background-color: #f2f2f2; /* Zebra-striping for rows */
}

.search-results-table tr:hover {
    background-color: #ddd; /* Hover effect for rows */
}



}
</style> 
</head>
<body>

    <div class="filter-container">
        <form id="filterForm">
            <input type="text" id="filterBuyerName" placeholder="Magaca iibsadaha ku baadh">
            <input type="date" id="filterStartDate">
            <input type="date" id="filterEndDate">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="table-container">
        <!-- The search results table will go here -->
    </div>
    <div class="right-container">
    <!-- Buttons will be added here -->
</div>


 <script>
   document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const buyerName = document.getElementById('filterBuyerName').value;
    const startDate = document.getElementById('filterStartDate').value;
    const endDate = document.getElementById('filterEndDate').value;

    if (!buyerName) {
        alert("Please enter a Buyer Name to search.");
        return;
    }

    // Make an AJAX call to your PHP script with these parameters
    fetch('findcredit.php', {
        method: 'POST',
        body: JSON.stringify({ buyerName, startDate, endDate }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableContainer = document.querySelector('.table-container');
        tableContainer.innerHTML = '';

        // Display total sale for the buyer
        const totalSaleDisplay = document.createElement('p');
        totalSaleDisplay.textContent = `Total Sale for ${buyerName}: $${parseFloat(data.totalSale).toFixed(2)}`;
        tableContainer.appendChild(totalSaleDisplay);

        // Check if there are sales results
        if (data.sales.length === 0) {
            tableContainer.innerHTML += '<p>No sales records found.</p>';
            return;
        }

        // Create a table for sales data
        const table = document.createElement('table');
        table.className = 'search-results-table';

        // Add a header row
        const headerRow = table.insertRow();
        ['ID', 'Buyer Name', 'Phone Number', 'Date', 'Quantity', 'Price', 'Returning Date'].forEach(headerText => {
            const headerCell = document.createElement('th');
            headerCell.textContent = headerText;
            headerRow.appendChild(headerCell);
        });

        // Add rows for each sale
        data.sales.forEach(sale => {
            const row = table.insertRow();
            // Add cells in the order of columns you want to display
            Object.values(sale).forEach(value => {
                const cell = row.insertCell();
                cell.textContent = value;
            });
        });

        // Append the table to the container
        tableContainer.appendChild(table);
        
    })
    .catch(error => console.error('Error:', error));
});


</script>

</body>
</html>
