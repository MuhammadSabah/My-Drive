<?php
function render_table($folderId, $db)
{
    // Files fetch
    $read_from_file  = $db->prepare("SELECT * FROM file WHERE folderId = $folderId");
    $read_from_file->execute();
    $files = $read_from_file->fetchAll(PDO::FETCH_OBJ);
    // Folders fetch
    $read_from_folder  = $db->prepare("SELECT * FROM folder where name <> 'Home'");
    $read_from_folder->execute();
    $folders = $read_from_folder->fetchAll(PDO::FETCH_OBJ);

    // $all_files_and_folders = array_merge($files, $folders);
    foreach ($files as $file) {
        echo "<tr class='hover:bg-gray-200 '>
    <td class='p-4 w-4'>
        <div class='flex items-center'>
            <input id='checkbox-table-$file->id' name='fileBox[]' value='$file->id'  type='checkbox' class='w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600'>
            <label for='checkbox-table-$file->id' class='sr-only'>checkbox</label>
        </div>
    </td>
    <td class='file-name-field py-4 px-6 text-sm underline font-medium text-blue-600 whitespace-nowrap cursor-pointer '><a >$file->fileName</a></td>
    <td class='py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap '>$file->date_modified</td>
    <td class='py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap '>$file->size MB</td>
    </tr>";
    }
    foreach ($folders as $folder) {
        echo "<tr class='hover:bg-gray-200 '>
    <td class='p-4 w-4'>
        <div class='flex items-center'>
            <input id='checkbox-table-$folder->id' name='fileBox[]' value='$folder->id'  type='checkbox' class='w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600'>
            <label for='checkbox-table-$folder->id' class='sr-only'>checkbox</label>
        </div>
    </td>
    <td id='folderName' data-folder=$folder->id class='file-name-field py-4 px-6 text-sm underline font-medium text-blue-600 whitespace-nowrap cursor-pointer '><a href='index.php?id=$folder->id'>$folder->name</a></td>
     <td class='py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap '>$folder->date_modified</td>
    </tr>";
    }
}
