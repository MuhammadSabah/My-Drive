<?php
require_once("../config/config.php");
require_once("../controller/get_response.php");
require_once("../controller/get_files.php");
require_once("../controller/render_table.php");

$date = new DateTime();
$date_modified = $date->format("Y-m-d H:i:s");
//
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
//
$current_folder = "Home";
//
// FILE UPLOAD
if (isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $path = '../uploads/' . $fileName;
    $id_param  = $_POST['folderID'];

    if (move_uploaded_file($fileTempName, $path)) {
        //
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
        //
        $insert_to_file = $db->prepare('INSERT INTO file(fileName,folderId,size,date_modified,file_path,is_folder) VALUES(:fileName,:folderId,:size,:date_modified,:file_path,:is_folder)');
        $insert_to_file->execute([
            'fileName' => $fileName,
            'folderId' => $id_param,
            'size' => bcdiv(filesize($path) / (1024 * 1024), 1, 3),
            'date_modified' => strval($date_modified),
            'file_path' => $path,
            'is_folder' => "false"
        ]);
        //
        $response = ['tableHTML' => get_response($db, $id_param)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// CREATE NEW FOLDER
if (isset($data->submitNewFolder)) {
    $newFolderName = $data->newFolder;
    $currentFolderID = $data->currentFolderID;

    $selectCurrentFolderName = $db->prepare('SELECT name FROM folder WHERE id = :id');
    $selectCurrentFolderName->execute([
        'id' => $currentFolderID,
    ]);
    $folder = $selectCurrentFolderName->fetch();

    if (!$folder) {
        $insertFolder = $db->prepare('INSERT INTO folder(name, date_modified) VALUES(:name,:date_modified)');
        $insertFolder->execute([
            'name' => $newFolderName,
            'date_modified' => strval($date_modified),
        ]);
    }
    $response = ['tableHTML' => get_response($db, $currentFolderID)];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// DELETE FILE
if (isset($data->fileBoxForDelete)) {
    //
    // $select = $db->prepare('SELECT * FROM folder WHERE name = :folderName');
    // $select->execute([
    //     'folderName' => $current_folder,
    // ]);
    // $folder = $select->fetch();
    //
    $fileIds = $data->fileBoxForDelete;

    if (!empty($fileIds)) {
        $placeholders = rtrim(str_repeat('?,', count($fileIds)), ',');
        $delete = $db->prepare("DELETE FROM file WHERE id IN ({$placeholders})");
        $delete2 = $db->prepare("DELETE FROM folder WHERE id IN ({$placeholders})");
        $delete->execute($fileIds);
        $delete2->execute($fileIds);
        $response = ['success' => true, 'message' => 'Selected files have been deleted.'];
    } else {
        $response = ['success' => false, 'message' => 'Error: Invalid parameters.'];
    }

    $response = ['tableHTML' => get_response($db, $data->folderID)];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// RENAME FILE
if (isset($data->fileBox)) {
    //
    $select = $db->prepare('SELECT * FROM folder WHERE name = :folderName');
    $select->execute([
        'folderName' => $current_folder,
    ]);
    $folder = $select->fetch();
    //
    $fileIds = $data->fileBox;
    $fullFile = $data->fullFile;
    $folderRenameID = $data->folderRenameID;

    $updateFile = $db->prepare("UPDATE file SET fileName=:fileName, date_modified=:date_modified WHERE id=:id");
    foreach ($fileIds as $id) {
        $updateFile->execute([
            'fileName' => $fullFile,
            'date_modified' => strval($date_modified),
            'id' => $id,
        ]);
    }

    $response = ['tableHTML' => get_response($db, $folderRenameID)];
    header('Content-Type: application/json');
    echo json_encode($response);;
}

// OPEN NEW FOLDER
if (isset($data->folderName)) {
    $folderName = $data->folderName;
    $current_folder = $folderName;
    $newFolderID = $data->folderId;

    $response = ['tableHTML' => get_files($db, $newFolderID)];
    header('Content-Type: application/json');
    echo json_encode($response);;
}
