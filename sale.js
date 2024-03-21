

   
let downloadButtonAdded = false; // Flag to track if the download button has been added

let deleteButtonAdded = false;

    function viewSalesHistory() {
        fetch("view_sales.php", {
            method: "GET"
        })
        .then(response => response.text())
        .then(data => {
            const table = document.getElementById("salesTable");
             table.innerHTML = "";
              table.innerHTML += data;

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
    // Select all checked checkboxes within the sales table
    const checkboxes = document.querySelectorAll('#salesTable input[name="deleteCheckbox"]:checked');

    // Loop over the checkboxes and remove the parent row for each
    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        row.remove();
    });

    // You may want to send this information back to the server to update the database
    // This would involve collecting the ids of the sales to delete and sending an AJAX request
}


    function addDownloadButton() {
        const downloadExcelButton = document.createElement("button");
        downloadExcelButton.innerText = "Download Excel";
        downloadExcelButton.onclick = downloadSalesTableAsExcel;

        const buttonContainer = document.createElement("div");
        buttonContainer.classList.add("button-container");
        buttonContainer.appendChild(downloadExcelButton);

        const rightContainer = document.querySelector('.right-container');
        rightContainer.appendChild(buttonContainer);
    }

   function downloadSalesTableAsExcel() {
    console.log("Download Excel button clicked!");
    const table = document.getElementById("salesTable");
    const ws = XLSX.utils.table_to_sheet(table);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sales Report");

    // Write the workbook to a file
    XLSX.writeFile(wb, "sales_report.xlsx");

        // Create a download link
        const a = document.createElement("a");
        a.href = URL.createObjectURL(blob);
        a.download = "sales_report.xlsx";

        // Append the link to the document and trigger the download
        document.body.appendChild(a);
        a.click();

        // Remove the link from the document
        document.body.removeChild(a);
    }

