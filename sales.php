<!DOCTYPE html>
<html>
<head>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
     


    </title>
    <style>
         body {
        font-family: Arial, sans-serif;
        background-color: #e8eff1; /* Light blue background */
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: flex-start;
    }

    .left-container,
    .right-container {
        flex: 1;
        padding: 10px;
        background-color: #ffffff; /* White background for containers */
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    h4 {
        text-align: center;
        background-color: #5dade2; /* Lighter blue for the header */
        color: #ffffff;
        padding: 10px;
        margin: 0;
        border-radius: 6px 6px 0 0; /* Rounded corners for header */
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333333; /* Darker text for better readability */
        font-weight: bold; /* Bold labels */
    }

    input[type="date"],
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #cccccc;
        border-radius: 4px; /* Slightly rounded corners for inputs */
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); /* Inner shadow for inputs */
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    button {
        background-color: #28b463; /* Green color for buttons */
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition for hover effect */
    }

    button:hover {
        background-color: #239b56; /* Darker shade of green on hover */
    }

    table {
        border-collapse: collapse;
        width: %;
        background-color: #f7f7f7; /* Light gray background for table */
    }

    table, th, td {
        border: 1px solid #dddddd; /* Lighter border for the table */
    }

    th, td {
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #3498db; /* Blue color for table headers */
        color: white;
    }

    .see-sales-button {
        background-color: #f39c12; /* Orange color for special buttons */
        margin-top: 10px;
        align-self: flex-end;
    }

    .see-sales-button:hover {
        background-color: #d68910; /* Darker orange on hover */

    }
    @media screen and (max-width: 768px) {
    body {
        flex-direction: column;
    }
    .left-container,
    .right-container {
        flex: none;
        width: 100%;
    }
}
@media screen and (max-width: 768px) {
    .right-container {
        overflow-x: auto; /* Allows table to scroll horizontally */
    }
}

    #paginationLinks {
        position: absolute;
        right: 10px;
        bottom: 10px;
    }

    #paginationLinks button {
        margin-left: 5px; /* Spacing between buttons */
    }
    </style>
</head>
<body>
    <h4>Xogta laga iibsadaha</h4>
   <div class="left-container">
        <label for="buyer_name">laga iibsade:</label>
    <input type="text" id="buyer_name">
    <label for="phone_number">Nambarka:</label>
    <input type="tel" id="phone_number">
    <label for="date">Tarikhda:</label>
    <input type="date" id="date">
    <label for="product">Nooca xoolaha:</label>
    <input type="text" id="product">
    <label for="quantity">Tirada adhiga:</label>
    <input type="number" id="quantity">
    <label for="price">Qiimaha:</label>
    <input type="number" id="price">
    <label for="expenses">Kharashka:</label>
    <input type="number" id="expenses">
    <button onclick="addSale()">Add Sale</button>
    <div class="button-container">
    <button class="see-sales-button" onclick="viewSalesHistory()">See Sales</button>
   
</div>

</div>


  <div class="right-container">
   <table id="salesTable">
    <tr>
          <th>ID</th>
        <th>Laga iibsade</th>
        <th>Nambarka</th>
        <th>Taarikhda</th>
        <th>Nooca adhiga</th>
        <th>Tirada adhiga</th>
        <th>Qiimaha lagu iibsaday</th>
        <th>Kharashka baxay</th>
       <th>Total</th>
         
    </tr>
</table>
<div id="totalSalesDisplay">Totalka xoolaha la soo ibsaday: </div>
<div id="totalExpensesDisplay">Totalka Kharashadka baxay:</div>

</div>
<div id="paginationLinks">
<script>

   
function addSale() {
    console.log("addSale function is running");
    const buyerName = document.getElementById("buyer_name").value;
    const phoneNumber = document.getElementById("phone_number").value;
    const date = document.getElementById("date").value;
    const product = document.getElementById("product").value;
    const quantity = document.getElementById("quantity").value;
    const price = document.getElementById("price").value;
    const expenses = document.getElementById("expenses").value;
    const total = quantity * price;

    if (!buyerName || !phoneNumber || !date || !product || !quantity || !price || !expenses) {
        alert("Please fill in all fields before adding a sale.");
        return;
    }

    const formData = new FormData();
    formData.append("buyer_name", buyerName);
    formData.append("phone_number", phoneNumber);
    formData.append("date", date);
    formData.append("product", product);
    formData.append("quantity", quantity);
    formData.append("price", price);
    formData.append("expenses", expenses);
    formData.append("total", total);

    fetch("add_sale.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(lastId => {
        const table = document.getElementById("salesTable");
        const row = table.insertRow(-1);
        row.setAttribute('data-sale-id', lastId);

        // Insert cells in the order of the table headings
        row.insertCell(0).innerHTML = lastId; // Set the ID from the server
        row.insertCell(1).innerHTML = buyerName;
        row.insertCell(2).innerHTML = phoneNumber;
        row.insertCell(3).innerHTML = date;
        row.insertCell(4).innerHTML = product;
        row.insertCell(5).innerHTML = quantity;
        row.insertCell(6).innerHTML = price;
        row.insertCell(7).innerHTML = expenses;
        row.insertCell(8).innerHTML = total.toFixed(2);
            updateTotalSalesFromServer()
            updateTotalExpensesFromServer()
    })
    .catch(error => console.error(error));

}
   
let downloadButtonAdded = false; // Flag to track if the download button has been added

let deleteButtonAdded = false;
function viewSalesHistory(page = 1) {
    fetch(`view_sales.php?page=${page}`)
    .then(response => response.text())
    .then(data => {
        const table = document.getElementById("salesTable");
        table.innerHTML = table.rows[0].outerHTML + data;


        updatePaginationLinks(page);
        updateTotalExpensesFromServer()
       updateTotalSalesFromServer()

               addCheckboxesToRows();

       
            if (!downloadButtonAdded) {
            addDownloadButton();
            downloadButtonAdded = true;
        }

        })
        .catch(error => console.error(error));
    }
function addCheckboxesToRows() {
    const table = document.getElementById("salesTable");
    const rows = table.querySelectorAll("tr");

    rows.forEach((row, index) => {
        if (index === 0) {
            // Skip header row
            return;
        }

        const checkboxCell = row.insertCell(-1);
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.name = "deleteCheckbox";
        checkboxCell.appendChild(checkbox);

        checkbox.addEventListener("change", function () {
            updateDeleteButtonState();
        });
    });
}

// Remove the addDeleteButton function

/// Remove the addDeleteButton function

// Function to add the delete button
function addDeleteButton() {
    const deleteButton = document.createElement("button");
    deleteButton.id = "deleteButton";
    deleteButton.innerText = "Delete";
    deleteButton.classList.add("delete-button");
    deleteButton.onclick = handleDelete; // Assign the delete function to the button

    const buttonContainer = document.createElement("div");
    buttonContainer.classList.add("button-container");
    buttonContainer.appendChild(deleteButton);

    const rightContainer = document.querySelector('.right-container');
    rightContainer.appendChild(buttonContainer);
}

// Add the delete button when the page loads
addDeleteButton();

// Function to handle delete
function handleDelete() {
   const checkboxes = document.querySelectorAll('#salesTable input[name="deleteCheckbox"]:checked');

    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        const saleId = row.getAttribute('data-sale-id'); // Assuming each row has a data attribute with the sale ID

        fetch('delete_sale.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'saleId=' + saleId
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            row.remove(); // Remove the row from the table if the server deletion was successful
            updateTotalSalesFromServer()
            updateTotalExpensesFromServer()
        })
        .catch(error => console.error('Error:', error));
    });
}


    function addDownloadButton() {
    const downloadPDFButton = document.createElement("button");
    downloadPDFButton.innerText = "Download PDF";
    downloadPDFButton.onclick = downloadSalesTableAsPDF;

    const buttonContainer = document.createElement("div");
    buttonContainer.classList.add("button-container");
    buttonContainer.appendChild(downloadPDFButton);

    const rightContainer = document.querySelector('.right-container');
    rightContainer.appendChild(buttonContainer);
}

function downloadSalesTableAsPDF() {
    const table = document.getElementById("salesTable");
    table.style.backgroundColor = 'white';

    html2canvas(table, {
        scale: 1,
        windowWidth: table.scrollWidth,
        windowHeight: table.scrollHeight,
        backgroundColor: 'white'
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jspdf.jsPDF({
            orientation: 'l',
            unit: 'pt',
            format: [canvas.width, canvas.height + 30]
        });

        pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);

        const footerText = "Warsame Company @receipt";
        pdf.setFontSize(10);
        pdf.text(footerText, 10, canvas.height + 20);

        pdf.save('sales_report.pdf');
    });
}

// pagination

 function updatePaginationLinks(currentPage) {
    const paginationDiv = document.getElementById("paginationLinks");
    paginationDiv.innerHTML = '';

    if (currentPage > 1) {
        const prevButton = document.createElement("button");
        prevButton.innerText = "Previous";
        prevButton.onclick = () => viewSalesHistory(currentPage - 1);
        paginationDiv.appendChild(prevButton);
    }

    const nextButton = document.createElement("button");
    nextButton.innerText = "Next";
    nextButton.onclick = () => viewSalesHistory(currentPage + 1);
    paginationDiv.appendChild(nextButton);
}
//TotAL SALES
function updateTotalSalesFromServer() {
    fetch('calculate_total_sales.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById("totalSalesDisplay").innerText = `Totalka xoolaha la soo ibsaday: $${parseFloat(data.totalSales).toFixed(2)}`;
    })
    .catch(error => console.error('Error:', error));
}
//TOTAL EXPENSES
function updateTotalExpensesFromServer() {
    fetch('calculate_total_expenses.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById("totalExpensesDisplay").innerText = `Totalka kharashaadka baxay: $${parseFloat(data.totalExpenses).toFixed(2)}`;
    })
    .catch(error => console.error('Error:', error));
}

    

</script>
    </body>
</html>
