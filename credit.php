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
        align-items: flex-start;
        justify-content: space-around;
    }

    .left-container,
    .right-container {
        flex: 1;
        padding: 10px;
        background-color: #ffffff; /* White background for containers */
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    h1 {
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
        width: 100%;
        background-color: #f7f7f7; /* Light gray background for table */
    }

    table, th, td {
        border: 1px solid #dddddd; /* Lighter border for the table */
    }

    th, td {
        padding: 10px;
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
//pagination css
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
    <h1></h1>
   <div class="left-container">
        <label for="buyer_name">Magaca iibsadaha xolaha dhofay:</label>
    <input type="text" id="buyer_name">
    <label for="phone_number">Nambarka:</label>
    <input type="tel" id="phone_number">
    <label for="date">Tarikhda la iibiyay:</label>
    <input type="date" id="date">
   
    <label for="quantity">Tirada xoolaha:</label>
    <input type="number" id="quantity">
    <label for="price">Qiimaha:</label>
    <input type="number" id="price">
    
     <label for="returning">wakhtiga la soo celinayo Lacagta:</label>
    <input type="date" id="re-date">
   
    <button onclick="addSale()">Add Sale</button>
    <div class="button-container">
    <button class="see-sales-button" onclick="viewSalesHistory()">See Sales</button>
   
</div>

</div>


  <div class="right-container">
   <table id="salesTable">
    <tr>
         <th>ID</th>
        <th>Magaca iibsadaha</th>
        <th>Nambarka</th>
        <th>Taarikhda</th>
        <th>Tirada Xoolaha</th>
        <th>Qiimaha</th>
        
        <th>wakhtiga la soo celinayo</th>
         <th>Total</th>
         
    </tr>
</table>
<div id="totalSalesDisplay">Isugaynta Qiimaha Xolaha La dhofiyay:</div>
</div>


<div id="paginationLinks">

<script>

   
function addSale() {
    console.log("addSale function is running");
    const buyerName = document.getElementById("buyer_name").value;
    const phoneNumber = document.getElementById("phone_number").value;
    const date = document.getElementById("date").value;
    const quantity = document.getElementById("quantity").value;
    const price = document.getElementById("price").value;
    const returning = document.getElementById("re-date").value;
    const total = quantity * price;

    if (!buyerName || !phoneNumber || !date || !quantity || !price || !returning) {
        alert("Please fill in all fields before adding a sale.");
        return;
    }

    const formData = new FormData();
    formData.append("buyer_name", buyerName);
    formData.append("phone_number", phoneNumber);
    formData.append("date", date);
    formData.append("quantity", quantity);
    formData.append("price", price);
    formData.append("returning", returning);
     formData.append("total", total);
    fetch("add_credit.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(lastId => {
           
        // Use the lastId from the server in the new table row
        const table = document.getElementById("salesTable");
        const row = table.insertRow(-1);
        row.setAttribute('data-sale-id', lastId);
       
const saleDate = new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
const returningDate = new Date(returning).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        // Insert cells in the order of the table headings
        row.insertCell(0).innerHTML = lastId; // Set the ID from the database
        row.insertCell(1).innerHTML = buyerName;
        row.insertCell(2).innerHTML = phoneNumber;
        row.insertCell(3).innerHTML = date;
        row.insertCell(4).innerHTML = quantity;
        row.insertCell(5).innerHTML = price;
        row.insertCell(6).innerHTML = returning;
         row.insertCell(7).innerHTML = total.toFixed(2);
        // Optionally, clear the form fields after adding
        document.getElementById("buyer_name").value = '';
        document.getElementById("phone_number").value = '';
        document.getElementById("date").value = '';
        document.getElementById("quantity").value = '';
        document.getElementById("price").value = '';
        document.getElementById("re-date").value = '';

         updateTotalSalesFromServer()
    })
    .catch(error => console.error(error));
}

   
let downloadButtonAdded = false; // Flag to track if the download button has been added

let deleteButtonAdded = false;
function viewSalesHistory(page = 1) {
    fetch(`view_credit.php?page=${page}`)
    .then(response => response.text())
    .then(data => {
        const table = document.getElementById("salesTable");
        table.innerHTML = table.rows[0].outerHTML + data;
        updatePaginationLinks(page);
               addCheckboxesToRows();
    updateTotalSalesFromServer()
       
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

        fetch('delete_credit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'saleId=' + saleId
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show an alert with the response message
            console.log(data);
            row.remove(); // Remove the row from the table if the server deletion was successful
               updateTotalSalesFromServer()

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

//pagination

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
//   TOTAL calculation
function updateTotalSalesFromServer() {
    fetch('calculate_total_credit.php')
    .then(response => response.json())
    .then(data => {
        // Convert the total sales from string to number
        const totalSales = parseFloat(data.totalSales);
        document.getElementById("totalSalesDisplay").innerText = `Isu gaynta Qiimaha xolaha la dhofiyay: $${totalSales.toFixed(2)}`;
    })
    .catch(error => {
        console.error('Fetch error:', error);
        // Handle/display the error on the page
    });
}



</script>
    </body>
</html>
