<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Builder - Drag & Drop</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .component-item {
            cursor: grab;
            user-select: none;
        }

        .component-item:active {
            cursor: grabbing;
        }

        .component-item.dragging {
            opacity: 0.5;
            transform: scale(0.95);
        }

        #canvas.drag-over,
        .droppable-zone.drag-over {
            border-color: #3b82f6 !important;
            background-color: #eff6ff !important;
        }

        .component-wrapper {
            position: relative;
            transition: all 0.2s;
        }

        .component-wrapper:hover {
            box-shadow: 0 0 0 2px #3b82f6;
        }

        .action-buttons {
            display: none;
        }

        .component-wrapper:hover .action-buttons {
            display: flex !important;
        }

        [contenteditable="true"]:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
            border-radius: 4px;
        }

        .toast-notification {
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body class="bg-gray-100 h-screen overflow-hidden">

    <div class="flex h-full">

        <!-- LEFT SIDEBAR - COMPONENTS PALETTE -->
        <aside class="w-72 bg-white border-r border-gray-300 flex flex-col shadow-lg">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200 bg-blue-600">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-puzzle-piece"></i>
                    Components Library
                </h2>
                <p class="text-xs text-blue-100 mt-1">Drag components to canvas</p>
            </div>

            <!-- Search -->
            <div class="p-3 border-b border-gray-200 bg-gray-50">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search components..."
                        class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                </div>
            </div>

            <!-- Components List -->
            <div id="componentsList" class="flex-1 overflow-y-auto p-3">
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-spinner fa-spin text-2xl"></i>
                    <p class="text-sm mt-2">Loading components...</p>
                </div>
            </div>
        </aside>

        <!-- MAIN CANVAS AREA -->
        <main class="flex-1 flex flex-col">

            <!-- Top Toolbar -->
            <header class="bg-white border-b border-gray-300 px-6 py-3 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Page Builder</h1>
                        <p class="text-xs text-gray-500">Drag, drop, and customize your page</p>
                    </div>

                    <div class="flex gap-2">
                        <button id="clearBtn"
                            class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center gap-2 text-sm font-medium">
                            <i class="fas fa-trash"></i>
                            Clear All
                        </button>
                        <button id="previewBtn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2 text-sm font-medium">
                            <i class="fas fa-eye"></i>
                            Preview
                        </button>
                        <button id="exportBtn"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2 text-sm font-medium">
                            <i class="fas fa-download"></i>
                            Export HTML
                        </button>
                    </div>
                </div>
            </header>

            <!-- Canvas Area -->
            <div class="flex-1 overflow-y-auto p-6">
                <div id="canvas"
                    class="min-h-full bg-white rounded-xl shadow-sm border-2 border-dashed border-gray-300 p-8">
                    <div id="emptyState" class="text-center py-20">
                        <div class="inline-block p-6 bg-blue-50 rounded-full mb-4">
                            <i class="fas fa-mouse-pointer text-5xl text-blue-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">Start Building Your Page</h3>
                        <p class="text-gray-500 mb-6">Drag components from the left sidebar and drop them here</p>
                        <div class="flex gap-3 justify-center">
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-hand-pointer text-blue-600 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-600">Drag</p>
                            </div>
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-arrow-right text-green-600 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-600">Drop</p>
                            </div>
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-edit text-purple-600 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-600">Edit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <!-- PREVIEW MODAL -->
    <div id="previewModal"
        class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center p-6">
        <div class="bg-white rounded-xl w-full max-w-6xl max-h-[95vh] flex flex-col shadow-2xl">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50 rounded-t-xl">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Preview Mode</h2>
                    <p class="text-sm text-gray-500">This is how your page will look</p>
                </div>
                <button id="closePreviewBtn" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="previewContent" class="flex-1 overflow-y-auto p-8 bg-gray-50">
                <!-- Preview content will be inserted here -->
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toast"
        class="hidden fixed top-6 right-6 bg-white border-l-4 border-green-500 rounded-lg shadow-xl p-4 z-50 toast-notification min-w-[300px]">
        <div class="flex items-start gap-3">
            <i id="toastIcon" class="fas fa-check-circle text-green-500 text-2xl"></i>
            <div class="flex-1">
                <p id="toastMessage" class="font-semibold text-gray-800 text-sm"></p>
                <p id="toastSubtext" class="text-xs text-gray-600 mt-1"></p>
            </div>
            <button id="closeToastBtn" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- SAVE TO SERVER MODAL -->
    <div id="saveModal" class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center p-6">
        <div class="bg-white rounded-xl w-full max-w-md shadow-2xl">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50 rounded-t-xl">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Save Note</h2>
                    <p class="text-sm text-gray-500">Save your page as a note</p>
                </div>
                <button id="closeSaveModalBtn" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="saveNoteForm">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Topic <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="noteTopic" list="topicsList"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Web Development" required>
                        <datalist id="topicsList"></datalist>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sub Topic
                        </label>
                        <input type="text" id="noteSubTopic" list="subTopicsList"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., React Components">
                        <datalist id="subTopicsList"></datalist>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="noteDescription" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Brief description of this note..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" id="cancelSaveBtn"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            Cancel
                        </button>
                        <button type="button" id="saveNoteBtn"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-save mr-2"></i>Save Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOAD FROM SERVER MODAL -->
    <div id="loadNotesModal"
        class="hidden fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center p-6">
        <div class="bg-white rounded-xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50 rounded-t-xl">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Load Note</h2>
                    <p class="text-sm text-gray-500">Select a note to load</p>
                </div>
                <button id="closeLoadModalBtn" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="notesListContainer" class="flex-1 overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center py-12 text-gray-400 col-span-2">
                    <i class="fas fa-spinner fa-spin text-3xl mb-3"></i>
                    <p>Loading notes...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add new buttons to toolbar
            var serverButtons = `
                <button id="saveToServerBtn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition flex items-center gap-2 text-sm font-medium">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Save to Server
                </button>
                <button id="loadFromServerBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2 text-sm font-medium">
                    <i class="fas fa-cloud-download-alt"></i>
                    Load from Server
                </button>
            `;

            $('header .flex.gap-2').prepend(serverButtons);
        });
    </script>
    <!-- Load JavaScript Files -->
    <script src="{{ asset('js/page-builder/components-data.js') }}"></script>
    <script src="{{ asset('js/page-builder/drag-drop.js') }}"></script>
    <script src="{{ asset('js/page-builder/actions.js') }}"></script>
    <script src="{{ asset('js/page-builder/utils.js') }}"></script>
    <script src="{{ asset('js/page-builder/server-save.js') }}"></script>

</body>

</html>
