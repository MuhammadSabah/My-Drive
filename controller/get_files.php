<?php
function get_files($db, $folderId)
{
    $readFiles = $db->prepare("SELECT * FROM file WHERE folderId = :folderId");
    $readFiles->execute(['folderId' => $folderId]);
    $files = $readFiles->fetchAll(PDO::FETCH_OBJ);
    //
    $data = [];
    foreach ($files as $file) {
        $row = array(
            'id' => $file->id,
            'fileName' => $file->fileName,
            'folderId' => $file->folderId,
            'date_modified' => $file->date_modified,
            'size' => $file->size . ' MB',
            'filePath' => $file->file_path,
        );
        array_push($data, $row);
    }
    return $data;
}
