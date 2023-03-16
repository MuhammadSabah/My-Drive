<?php
require_once("../config/config.php");


$folderName = 'Home';
if (isset($_POST['submit'])) {
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

        $date = new DateTime();
        $date_modified = $date->format("Y-m-d H:i:s");
        $insert2->execute([
            'fileName' => $fileName,
            'folderName' => $folderName,
            'size' => bcdiv(filesize($path) / (1024 * 1024), 1, 3),
            'date_modified' => strval($date_modified),
        ]);
    } else {
        // Handle file upload error
        echo "Error uploading file";
    }
}
