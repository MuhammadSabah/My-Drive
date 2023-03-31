function generateTableRow(data) {
  return `
    <tr class='hover:bg-gray-200'>
      <td class='p-4 w-4 '>
        <div class='flex items-center'>
          <input id='checkbox-table-${data.id}'  name='fileBox[]' value='${data.id}' type='checkbox' class='w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600'>
          <label for='checkbox-table-${data.id}' class='sr-only'>checkbox</label>
        </div>
      </td>
      <td id='folderName' data-folder=${data.id} class='file-name-field py-4 px-6 text-sm underline font-medium text-blue-600 whitespace-nowrap cursor-pointer'><a href='index.php?id=${data.id}'>${data.fileName}</a></td>
      <td class='py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap'>${data.date_modified}</td>
      <td class='py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap'>${data.size}</td>
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
  const formData = new FormData();
  let folderID = document.querySelector(".hidden-input").value;
  const fileInput = document.querySelector("#file");
  //
  formData.append("file", fileInput.files[0]);
  formData.append("folderID", folderID);
  //
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
  let folderID = document.querySelector(".hidden-input").value;
  const fileIds = Array.from(
    document.querySelectorAll('input[name="fileBox[]"]:checked')
  ).map((checkbox) => checkbox.value);

  if (fileIds.length === 0) {
    alert("Please select at least one file to delete.");
    return;
  }
  fetch("./controller/file-manager.php", {
    method: "POST",
    body: JSON.stringify({ fileBoxForDelete: fileIds, folderID: folderID }),
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
  //
  let folderID = document.querySelector(".hidden-input").value;
  //

  fetch("./controller/file-manager.php", {
    method: "POST",
    body: JSON.stringify({
      fileBox: fileIds,
      fullFile: fullFile,
      folderRenameID: folderID,
    }),
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
  let currentFolderID = document.querySelector(".hidden-input").value;
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
      currentFolderID: currentFolderID,
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

// CLICK NEW FOLDER
const folderElements = document.querySelectorAll("#folderName");
folderElements.forEach((folderElement) => {
  folderElement.addEventListener("click", (event) => {
    event.preventDefault();
    let folderName = folderElement.textContent;
    let currentFolderID = document.querySelector(".hidden-input").value;

    fetch("./controller/file-manager.php", {
      method: "POST",
      body: JSON.stringify({
        folderName: folderName,
        folderId: currentFolderID,
      }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Failed to open new folder.");
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
        window.location.replace(`index.php?id=${currentFolderID}`);
        renderTableRows(data);
      })
      .catch((error) => {
        console.log(error.message);
      });
  });
});
