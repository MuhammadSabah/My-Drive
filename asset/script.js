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
const confirmDeleteBtn = document.getElementById("delete-submit-button");

const hideDeleteModal = function () {
  deleteModal.classList.add("hidden");
};
const showDeleteModal = function () {
  deleteModal.classList.remove("hidden");
};

deleteBtn.addEventListener("click", showDeleteModal);
cancelDeleteModal.addEventListener("click", hideDeleteModal);
confirmDeleteBtn.addEventListener("click", hideDeleteModal);

// 2) Rename Modal
const renameBtn = document.getElementById("rename-btn");
const renameModal = document.getElementById("rename-modal");
const cancelRenameModal = document.getElementById("cancel-rename-modal");
const renameInput = document.getElementById("file-name-input");
const fileExtensionElement = document.getElementById("file-extension");
const checkboxes = document.querySelectorAll('input[type="checkbox"]');
const confirmRenameBtn = document.getElementById("confirm-rename-btn");

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

const hideRenameModal = function () {
  renameModal.classList.add("hidden");
};
const showRenameModal = function () {
  renameModal.classList.remove("hidden");
};
renameBtn.addEventListener("click", showRenameModal);
cancelRenameModal.addEventListener("click", hideRenameModal);
confirmRenameBtn.addEventListener("click", hideRenameModal);

// 2) New Folder Modal
const newFolderBtn = document.getElementById("new-folder-btn");
const newFolderModal = document.getElementById("new-folder-modal");
const cancelNewFolderModal = document.getElementById("new-folder-cancel-modal");
const createNewFolderBtn = document.getElementById("new-folder-create-button");

const hideModal = function () {
  newFolderModal.classList.add("hidden");
};
const showModal = function () {
  newFolderModal.classList.remove("hidden");
};

newFolderBtn.addEventListener("click", showModal);
cancelNewFolderModal.addEventListener("click", hideModal);
createNewFolderBtn.addEventListener("click", hideModal);
