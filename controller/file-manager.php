<?php
require_once("../config/config.php");

$folderName = 'Home';
$date = new DateTime();
$date_modified = $date->format("Y-m-d H:i:s");
if (isset($_POST['submit-upload'])) {
    $fileName = $_FILES['file']['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $path = '../../../../../Downloads/test_files/' . $fileName;

    // Check if file was uploaded successfully
    if (move_uploaded_file($fileTempName, $path)) {
        $insert1 = $db->prepare('INSERT INTO folder(name) VALUE(:folderName)');
        $insert2 = $db->prepare('INSERT INTO file(fileName,folderName,size,date_modified) VALUE(:fileName,:folderName,:size,:date_modified)');

        // $insert1->execute([
        //     'folderName' => $folderName,
        // ]);

        $insert2->execute([
            'fileName' => $fileName,
            'folderName' => $folderName,
            'size' => bcdiv(filesize($path) / (1024 * 1024), 1, 3),
            'date_modified' => strval($date_modified),
        ]);
    } else {
        echo "Error uploading file";
    }
}
if (isset($_POST['submit-new-folder'])) {
    $newFolderName = $_POST["new-folder"];

    $insertFolder = $db->prepare('INSERT INTO folder(name) VALUE(:folderName)');

    $insertFolder->execute([
        'folderName' => $newFolderName,
    ]);
}
if (isset($_POST['submit-delete'])) {
    $fileIds = $_POST["fileBox"];

    $placeholders = rtrim(str_repeat('?,', count($fileIds)), ',');

    $delete = $db->prepare("DELETE FROM file WHERE id IN ({$placeholders})");

    $delete->execute($fileIds);
}

if (isset($_POST['submit-rename'])) {
    $fileSelected = $_POST["file-name-input"];
    $fileIds = $_POST["fileBox"];
    $fileExtension = $_POST["file-extension"];
    $fullFile = $fileSelected . $fileExtension;

    $updateFile = $db->prepare("UPDATE file SET fileName=:fileName, date_modified=:date_modified WHERE id=:id");

    foreach ($fileIds as $id) {
        $updateFile->execute([
            'fileName' => $fullFile,
            'id' => $id,
            'date_modified' => strval($date_modified),
        ]);
    }
}

header('Location: ../index.php');
exit();
