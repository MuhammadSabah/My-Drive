<?php
require_once("../config/config.php");

$folderName = 'Home';
$date = new DateTime();
$date_modified = $date->format("Y-m-d H:i:s");
//
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
//

// UPLOAD FILE
if (isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $path = '../../../../../Downloads/test_files/' . $fileName;

    if (move_uploaded_file($fileTempName, $path)) {
        $insert1 = $db->prepare('INSERT INTO folder(name) VALUE(:folderName)');
        $insert2 = $db->prepare('INSERT INTO file(fileName,folderName,size,date_modified) VALUE(:fileName,:folderName,:size,:date_modified)');

        $insert2->execute([
            'fileName' => $fileName,
            'folderName' => $folderName,
            'size' => bcdiv(filesize($path) / (1024 * 1024), 1, 3),
            'date_modified' => strval($date_modified),
        ]);
        //
        $read = $db->prepare("SELECT * FROM file");
        $read->execute();
        $files = $read->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach ($files as $file) {
            $row = array(
                'id' => $file->id,
                'fileName' => $file->fileName,
                'date_modified' => $file->date_modified,
                'size' => $file->size . ' MB'
            );
            array_push($data, $row);
        }
        $response = ['tableHTML' => $data];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// CREATE NEW FOLDER
if (isset($data->submitNewFolder)) {
    $newFolderName = $data->newFolder;
    $insertFolder = $db->prepare('INSERT INTO folder(name) VALUE(:folderName)');
    $insertFolder->execute([
        'folderName' => $newFolderName,
    ]);

    $read = $db->prepare("SELECT * FROM file");
    $read->execute();
    $files = $read->fetchAll(PDO::FETCH_OBJ);
    $data = array();
    foreach ($files as $file) {
        $row = array(
            'id' => $file->id,
            'fileName' => $file->fileName,
            'date_modified' => $file->date_modified,
            'size' => $file->size . ' MB'
        );
        array_push($data, $row);
    }
    $response = ['tableHTML' => $data];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// DELETE FILE
if (isset($data->fileBoxForDelete)) {
    $fileIds = $data->fileBoxForDelete;

    if (!empty($fileIds)) {
        $placeholders = rtrim(str_repeat('?,', count($fileIds)), ',');
        $delete = $db->prepare("DELETE FROM file WHERE id IN ({$placeholders})");
        $delete->execute($fileIds);
        $response = ['success' => true, 'message' => 'Selected files have been deleted.'];
    } else {
        $response = ['success' => false, 'message' => 'Error: Invalid parameters.'];
    }

    $read = $db->prepare("SELECT * FROM file");
    $read->execute();
    $files = $read->fetchAll(PDO::FETCH_OBJ);
    $data = array();
    foreach ($files as $file) {
        $row = array(
            'id' => $file->id,
            'fileName' => $file->fileName,
            'date_modified' => $file->date_modified,
            'size' => $file->size . ' MB'
        );
        array_push($data, $row);
    }
    $response = ['tableHTML' => $data];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// RENAME FILE
if (isset($data->fileBox)) {
    $fileIds = $data->fileBox;
    $fullFile = $data->fullFile;

    $updateFile = $db->prepare("UPDATE file SET fileName=:fileName, date_modified=:date_modified WHERE id=:id");

    foreach ($fileIds as $id) {
        $updateFile->execute([
            'fileName' => $fullFile,
            'date_modified' => strval($date_modified),
            'id' => $id,
        ]);
    }

    $read = $db->prepare("SELECT * FROM file");
    $read->execute();
    $files = $read->fetchAll(PDO::FETCH_OBJ);
    $data = array();
    foreach ($files as $file) {
        $row = array(
            'id' => $file->id,
            'fileName' => $file->fileName,
            'date_modified' => $file->date_modified,
            'size' => $file->size . ' MB'
        );
        array_push($data, $row);
    }
    $response = ['tableHTML' => $data];
    header('Content-Type: application/json');
    echo json_encode($response);;
}
