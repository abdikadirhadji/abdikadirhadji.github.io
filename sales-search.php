<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Search | Warsame Company</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <style>
        /* Your existing CSS */
        /* Add any new styles here */
        body {
    font-family: Arial, sans-serif;
    background-color: #e8eff1;
    padding: 20px;
}

.filter-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    margin: 20px auto;
    max-width: 600px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

#filterForm {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

#filterForm input[type="text"],
#filterForm input[type="date"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
}

#filterForm button {
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
}

#filterForm button:hover {
    background-color: #0056b3;
}

.table-container {
    margin: 20px auto;
    max-width: 800px;
}

.search-results-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.search-results-table th,
.search-results-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.search-results-table th {
    background-color: #28a745;
    color: white;
}

.search-results-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.search-results-table tr:hover {
    background-color: #ddd;
}

@media (max-width: 600px) {
    #filterForm input[type="text"],
    #filterForm input[type="date"],
    #filterForm button {
        width: 100%;
    }
}

    </style>
</head>
<body>
    <div class="filter-container">
        <form id="filterForm">
            <input type="text" id="filterBuyerName" placeholder="Search by Buyer Name">
            <input type="date" id="filterStartDate" placeholder="Start Date">
            <input type="date" id="filterEndDate" placeholder="End Date">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="table-container">
        <!-- Search results will be displayed here -->
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

        fetch('findsales.php', {
            method: 'POST',
            body: JSON.stringify({ buyerName, startDate, endDate }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            const tableContainer = document.querySelector('.table-container');
            tableContainer.innerHTML = '';

            if (data.sales.length === 0) {
                tableContainer.innerHTML = '<p>No records found for the selected buyer.</p>';
                return;
            }

            // Create total sales and expenses display
            const totalSalesDisplay = document.createElement('p');
            totalSalesDisplay.textContent = `Total Sales for ${buyerName}: $${parseFloat(data.totalSale).toFixed(2)}`;

            const totalExpensesDisplay = document.createElement('p');
            totalExpensesDisplay.textContent = `Total Expenses for ${buyerName}: $${parseFloat(data.totalExpense).toFixed(2)}`;

            tableContainer.appendChild(totalSalesDisplay);
            tableContainer.appendChild(totalExpensesDisplay);

            // Create the table
            const table = document.createElement('table');
            table.className = 'search-results-table';

            // Create table header
            const headerRow = table.insertRow();
            const headers = ['ID', 'Laga iibsaDaha', 'Nambarkiisa', 'Taarikhda', 'Nooca xolaha', 'Tirada adhiga', 'Qiimaha', 'kharashadka', 'total'];
            headers.forEach(headerText => {
                const headerCell = document.createElement('th');
                headerCell.textContent = headerText;
                headerRow.appendChild(headerCell);
            });

            // Create table rows
            data.sales.forEach(sale => {
                const row = table.insertRow();
                Object.values(sale).forEach(value => {
                    const cell = row.insertCell();
                    cell.textContent = value;
                });
            });

            tableContainer.appendChild(table);
const pdfButton = document.createElement('button');
        pdfButton.innerText = 'Download PDF';
        pdfButton.addEventListener('click', downloadTableAsPDF);
        tableContainer.appendChild(pdfButton);
    })
    .catch(error => console.error('Error:', error));
});

function downloadTableAsPDF() {
    const table = document.querySelector('.search-results-table');
    table.style.backgroundColor = 'white';

    html2canvas(table, {
        scale: 1,
        windowWidth: table.scrollWidth,
        windowHeight: table.scrollHeight,
        backgroundColor: 'white'
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jspdf.jsPDF({
            orientation: 'l', // Adjust orientation based on table width
            unit: 'pt',
            format: [canvas.width, canvas.height + 30] // Space for footer
        });

        pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);

        // Add footer text
        const footerText = "Warsame Company @receipt";
        pdf.setFontSize(10);
        pdf.text(footerText, 10, canvas.height + 20);

        pdf.save('credit_search_results.pdf');
    });
}
      
        
    </script>
</body>
</html>
