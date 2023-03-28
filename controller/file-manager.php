<?php
require_once("../config/config.php");
require_once("../controller/get_response.php");

$current_folder = 'Home';
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
        $select = $db->prepare('SELECT * FROM folder WHERE name = :folderName');
        $select->execute([
            'folderName' => $current_folder,
        ]);
        $folder = $select->fetch();

        if (!$folder) {
            $insert1 = $db->prepare('INSERT INTO folder(name) VALUES(:folderName)');
            $insert1->execute([
                'folderName' => $current_folder,
            ]);
        }

        $get_folder_id  = $db->prepare("SELECT * FROM folder where name = '$current_folder'");
        $get_folder_id->execute();
        $folder_id = $get_folder_id->fetch();
        $insert_to_file = $db->prepare('INSERT INTO file(fileName,folderId,size,date_modified) VALUES(:fileName,:folderId,:size,:date_modified)');

        $insert_to_file->execute([
            'fileName' => $fileName,
            'folderId' => $folder_id['id'],
            'size' => bcdiv(filesize($path) / (1024 * 1024), 1, 3),
            'date_modified' => strval($date_modified),
        ]);
        //
        $response = ['tableHTML' => get_response($db)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// CREATE NEW FOLDER
if (isset($data->submitNewFolder)) {
    $newFolderName = $data->newFolder;
    $select = $db->prepare('SELECT * FROM folder WHERE name = :folderName');
    $select->execute([
        'folderName' => $newFolderName,
    ]);
    $folder = $select->fetch();

    if (!$folder) {
        $insertFolder = $db->prepare('INSERT INTO folder(name, date_modified) VALUES(:folderName,:date_modified)');
        $insertFolder->execute([
            'folderName' => $newFolderName,
            'date_modified' => strval($date_modified),
        ]);
    }

    $response = ['tableHTML' => get_response($db)];
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

    $response = ['tableHTML' => get_response($db)];
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

    $response = ['tableHTML' => get_response($db)];
    header('Content-Type: application/json');
    echo json_encode($response);;
}
