<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link href="./dist/output.css" rel="stylesheet"> -->
    <link href="./asset/styles.css" rel="stylesheet">
    <script src="./asset/script.js" defer></script>

</head>

<body>
    <header>
        <nav class="relative px-24 py-4 flex justify-between items-center bg-gray-500">
            <a class="text-2xl font-bold leading-none text-white" href="">
                My Drive
            </a>
            <button class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-4 bg-red-500 hover:bg-red-600 text-sm text-white font-semibold  rounded-md transition duration-200" id="delete-btn">Delete</button>
            <button class="hidden lg:inline-block py-2 lg:mr-3 px-4 bg-gray-200 hover:bg-gray-300 text-sm text-black font-semibold rounded-md transition duration-200" id="rename-btn"> Rename</button>
            <button class="hidden lg:inline-block py-2 px-4 bg-gray-200 hover:bg-gray-300 text-sm text-black font-semibold rounded-md transition duration-200" id="new-folder-btn"> New Folder</button>
        </nav>
    </header>
    <main>
        <div class="bg-gray-200 px-24 py-4"><a href="#" class="text-blue-500 underline py-4 ">Home</a></div>
        <div class="px-24 py-8  ">
            <form action="./controller/file-manager.php" method="post" class="border border-gray-300 flex justify-between rounded-md">
                <div class="relative align-center flex">
                    <input type="file" class="hidden" name="file" id="file">
                    <label for="file" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-l-md cursor-pointer hover:bg-gray-300 transition-all ease-in-out duration-200">
                        Choose file
                    </label>
                    <span id="file-name" class="text-gray-500 ml-4 py-2">No file selected</span>

                </div>
                <button type="submit" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-r-md  hover:bg-blue-700 transition-all ease-in-out duration-200">
                    Upload
                </button>
            </form>
        </div>
        <div class="px-24 py-4 ">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 shadow-md">
                <thead class="bg-gray-100 ">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600">
                            </div>
                        </th>
                        <th scope="col" class="py-3 px-6 text-md font-semibold tracking-wider text-left   text-black">
                            Name
                        </th>
                        <th scope="col" class="py-3 px-6 text-md font-semibold tracking-wider text-left   text-black">
                            Last Modified
                        </th>
                        <th scope="col" class="py-3 px-6 text-md font-semibold tracking-wider text-left   text-black">
                            Size
                        </th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200  ">
                    <tr class="hover:bg-gray-200 ">
                        <td class="p-4 w-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600">
                                <label for="checkbox-table-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm underline font-medium text-blue-600 whitespace-nowrap cursor-pointer ">Word Document.docx</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap ">March 10, 2023 10:00am</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap ">1.5 MB</td>
                    </tr>
                </tbody>
            </table>
            <!-- DELETE MODAL -->
            <div class="relative z-10 hidden" aria-labelledby="modal-title" id="delete-modal" role="dialog" x-show="modalOpen" aria-modal="true">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Deleting Files</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Are you sure about deleting the selected files?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                                <button @click="modalOpen = false" id="cancel-delete-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RENAME MODAL -->
            <div class="relative z-10 hidden" aria-labelledby="modal-title" id="rename-modal" role="dialog" x-show="modalOpen" aria-modal="true">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">

                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Rename File</h3>
                                        <div class="mt-6 flex  border border-gray-300 rounded-md pl-4">
                                            <span id="file-name" class="text-gray-500 mr-[250px] py-2">No file selected</span>
                                            <label class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-md cursor-pointer hover:bg-gray-300 transition-all ease-in-out duration-200">
                                                .docx
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Rename</button>
                                <button @click="modalOpen = false" id="cancel-rename-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NEW FOLDER MODAL -->
            <div class="relative z-10 hidden" aria-labelledby="modal-title" id="new-folder-modal" role="dialog" x-show="modalOpen" aria-modal="true">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start ">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-[95%]">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">New Folder</h3>
                                        <div class="mt-6 ">
                                            <input type="text" class=" block w-full px-4 py-2 mt-2  text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:shadow-outline-blue " placeholder="Enter name here...">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Create</button>
                                    <button @click="modalOpen = false" id="new-folder-cancel-modal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</body>

</html>