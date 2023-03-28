<?php
function get_response($db)
{
    $readFiles = $db->prepare("SELECT * FROM file");
    $readFiles->execute();
    $files = $readFiles->fetchAll(PDO::FETCH_OBJ);
    //
    $readFolders = $db->prepare("SELECT * FROM folder where name <> 'Home'");
    $readFolders->execute();
    $folders = $readFolders->fetchAll(PDO::FETCH_OBJ);
    //
    $data = [];
    foreach ($files as $file) {
        $row = array(
            'id' => $file->id,
            'fileName' => $file->fileName,
            'folderId' => $file->folderId,
            'date_modified' => $file->date_modified,
            'size' => $file->size . ' MB'
        );
        array_push($data, $row);
    }
    foreach ($folders as $folder) {
        $row = array(
            'folderId' => $folder->id,
            'fileName' => $folder->name,
            'date_modified' => $folder->date_modified,
            'size' => ""
        );
        array_push($data, $row);
    }
    return $data;
}
