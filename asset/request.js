function generateTableRow(file) {
  return `
    <tr class='hover:bg-gray-200'>
      <td class='p-4 w-4'>
        <div class='flex items-center'>
          <input id='checkbox-table-${file.file_id}' name='fileBox[]' value='${file.id}' type='checkbox' class='w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600'>
          <label for='checkbox-table-${file.file_id}' class='sr-only'>checkbox</label>
        </div>
      </td>
      <td class='file-name-field py-4 px-6 text-sm underline font-medium text-blue-600 whitespace-nowrap cursor-pointer'><a>${file.fileName}</a></td>
      <td class='py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap'>${file.date_modified}</td>
      <td class='py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap'>${file.size}</td>
    </tr>
  `;
}

function renderTableRows(files) {
  const tableBody = document.querySelector("#file-table-body");
  let tableRows = "";

  files.tableHTML.forEach((file) => {
    tableRows += generateTableRow(file);
  });

  tableBody.innerHTML = tableRows;
}
////////////////////////////////////////
// UPLOAD FILE
const uploadForm = document.querySelector("#form");
const uploadSubmitButton = document.querySelector("#upload-submit-button");

uploadSubmitButton.addEventListener("click", (event) => {
  event.preventDefault();

  const formData = new FormData(uploadForm);
  const fileInput = document.querySelector("#file");

  if (!fileInput.files[0]) {
    alert("Please select a file to upload.");
    return;
  }

  fetch("./controller/file-manager.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      console.log(response);
      if (!response.ok) {
        throw new Error("Failed to upload file.");
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
      renderTableRows(data);
    })
    .catch((error) => {
      console.log(error.message);
    });
});

///////////////////////////////////////////////
// DELETE FILE
const deleteButton = document.querySelector("#delete-submit-button");
deleteButton.addEventListener("click", (event) => {
  event.preventDefault();
  const fileIds = Array.from(
    document.querySelectorAll('input[name="fileBox[]"]:checked')
  ).map((checkbox) => checkbox.value);

  if (fileIds.length === 0) {
    alert("Please select at least one file to delete.");
    return;
  }
  fetch("./controller/file-manager.php", {
    method: "POST",
    body: JSON.stringify({ fileBoxForDelete: fileIds }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to delete files.");
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
      renderTableRows(data);
    })
    .catch((error) => {
      console.log(error.message);
    });
});

////////////////////////////////////////
// RENAME FILE
const confirmRenameBtn = document.querySelector("#confirm-rename-btn");
const renameForm = document.getElementById("form");
confirmRenameBtn.addEventListener("click", (event) => {
  event.preventDefault();
  const fileIds = Array.from(
    document.querySelectorAll('input[name="fileBox[]"]:checked')
  ).map((checkbox) => checkbox.value);

  if (fileIds.length === 0) {
    alert("Please select at least one file to rename.");
    return;
  }
  const fileExtension = document.querySelector("#file-extension").value;
  const fileSelected = document.querySelector("#file-name-input").value;
  const fullFile = fileSelected + fileExtension;

  fetch("./controller/file-manager.php", {
    method: "POST",
    body: JSON.stringify({ fileBox: fileIds, fullFile: fullFile }),
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json, text/plain, */*",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to rename files.");
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
      renderTableRows(data);
    })
    .catch((error) => {
      console.log(error.message);
    });
});

////////////////////////////////////////
// NEW FOLDER
const submitButton = document.querySelector("#new-folder-create-button");
submitButton.addEventListener("click", (event) => {
  event.preventDefault();
  const newFolderName = document.querySelector("#new-folder-input").value;
  if (
    newFolderName.trim() === "" ||
    newFolderName == null ||
    newFolderName == undefined ||
    newFolderName == ""
  ) {
    alert("Folder name cannot be empty.");
    return;
  }
  fetch("./controller/file-manager.php", {
    method: "POST",
    body: JSON.stringify({
      submitNewFolder: true,
      newFolder: newFolderName,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to create folder.");
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
      renderTableRows(data);
    })
    .catch((error) => {
      console.log(error.message);
    });
});
