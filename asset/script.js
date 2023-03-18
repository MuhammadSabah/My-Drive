const rowCheckboxes = document.querySelectorAll(
  'input[type="checkbox"][id^="checkbox-table-"]'
);
const selectAllCheckbox = document.querySelector("#checkbox-all");

selectAllCheckbox.addEventListener("click", () => {
  rowCheckboxes.forEach((checkbox) => {
    checkbox.checked = selectAllCheckbox.checked;
  });
});

document.getElementById("file").addEventListener("change", function (e) {
  document.getElementById("file-name").innerHTML = this.files[0].name;
});

// MODALS
// 1) Delete Modal
const deleteBtn = document.getElementById("delete-btn");
const deleteModal = document.getElementById("delete-modal");
const cancelDeleteModal = document.getElementById("cancel-delete-modal");

deleteBtn.addEventListener("click", function () {
  deleteModal.classList.remove("hidden");
});

cancelDeleteModal.addEventListener("click", function () {
  deleteModal.classList.add("hidden");
});

// 2) Rename Modal
const renameBtn = document.getElementById("rename-btn");
const renameModal = document.getElementById("rename-modal");
const cancelRenameModal = document.getElementById("cancel-rename-modal");
const renameInput = document.getElementById("file-name-input");
const fileExtensionElement = document.getElementById("file-extension");
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

checkboxes.forEach(function (checkbox) {
  checkbox.addEventListener("change", function () {
    if (this.checked) {
      let fileName =
        this.closest("tr").querySelector(".file-name-field").textContent;
      const fileExtension = fileName.split(".").pop();
      fileName = fileName.replace("." + fileExtension, "");
      fileExtensionElement.value = "." + fileExtension;
      renameInput.value = fileName;
    }
  });
});
renameBtn.addEventListener("click", function () {
  renameModal.classList.remove("hidden");
});
cancelRenameModal.addEventListener("click", function () {
  renameModal.classList.add("hidden");
});
// 2) New Folder Modal
const newFolderBtn = document.getElementById("new-folder-btn");
const newFolderModal = document.getElementById("new-folder-modal");
const cancelNewFolderModal = document.getElementById("new-folder-cancel-modal");
const createNewFolderBtn = document.getElementById("new-folder-create-button");

newFolderBtn.addEventListener("click", function () {
  newFolderModal.classList.remove("hidden");
});
cancelNewFolderModal.addEventListener("click", function () {
  newFolderModal.classList.add("hidden");
});
createNewFolderBtn.addEventListener("click", function () {
  newFolderModal.classList.add("hidden");
});
