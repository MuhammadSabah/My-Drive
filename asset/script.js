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

newFolderBtn.addEventListener("click", function () {
  newFolderModal.classList.remove("hidden");
});
cancelNewFolderModal.addEventListener("click", function () {
  newFolderModal.classList.add("hidden");
});
