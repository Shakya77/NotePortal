$(document).ready(function () {
    initializeServerSave();
});

var currentNoteId = null;

function initializeServerSave() {
    // Save to server button
    $('#saveToServerBtn').on('click', function () {
        openSaveModal();
    });

    // Load from server button
    $('#loadFromServerBtn').on('click', function () {
        openLoadModal();
    });

    // Save modal - save button
    $('#saveNoteBtn').on('click', function () {
        saveNoteToServer();
    });

    // Close save modal
    $('#closeSaveModalBtn, #cancelSaveBtn').on('click', function () {
        closeSaveModal();
    });

    // Close load modal
    $('#closeLoadModalBtn').on('click', function () {
        closeLoadModal();
    });

    // Load notes when modal opens
    $(document).on('click', '#loadFromServerBtn', function () {
        loadNotesFromServer();
    });

    // Topic change - load sub topics
    $('#noteTopic').on('change', function () {
        var topic = $(this).val();
        if (topic) {
            loadSubTopics(topic);
        }
    });
}

function openSaveModal() {
    // Check if canvas has content
    if ($('#canvas .component-wrapper').length === 0) {
        showToast('Please add some components before saving', 'error');
        return;
    }

    $('#saveModal').removeClass('hidden');
    loadExistingTopics();
}

function closeSaveModal() {
    $('#saveModal').addClass('hidden');
    $('#saveNoteForm')[0].reset();
    currentNoteId = null;
}

function openLoadModal() {
    $('#loadNotesModal').removeClass('hidden');
    loadNotesFromServer();
}

function closeLoadModal() {
    $('#loadNotesModal').addClass('hidden');
}

function loadExistingTopics() {
    $.ajax({
        url: '/api/notes/topics',
        method: 'GET',
        success: function (response) {
            if (response.success) {
                var $select = $('#noteTopic');
                $select.find('option:not(:first)').remove();

                $.each(response.data, function (index, topic) {
                    $select.append('<option value="' + topic + '">' + topic + '</option>');
                });
            }
        },
        error: function (xhr) {
            console.error('Error loading topics:', xhr);
        }
    });
}

function loadSubTopics(topic) {
    $.ajax({
        url: '/api/notes/topics/' + encodeURIComponent(topic) + '/sub-topics',
        method: 'GET',
        success: function (response) {
            if (response.success) {
                var $select = $('#noteSubTopic');
                $select.find('option:not(:first)').remove();

                $.each(response.data, function (index, subTopic) {
                    if (subTopic) {
                        $select.append('<option value="' + subTopic + '">' + subTopic + '</option>');
                    }
                });
            }
        },
        error: function (xhr) {
            console.error('Error loading sub topics:', xhr);
        }
    });
}

function saveNoteToServer() {
    var topic = $('#noteTopic').val();
    var subTopic = $('#noteSubTopic').val();
    var description = $('#noteDescription').val();

    if (!topic) {
        showToast('Please enter a topic', 'error');
        return;
    }

    // Get canvas content
    var $canvas = $('#canvas').clone();
    $canvas.find('#emptyState').remove();
    var content = $canvas.html();

    if (!content || content.trim() === '') {
        showToast('Canvas is empty. Please add some components.', 'error');
        return;
    }

    var data = {
        topic: topic,
        sub_topic: subTopic,
        description: description,
        content: content
    };

    var url = '/api/notes';
    var method = 'POST';

    if (currentNoteId) {
        url = '/api/notes/' + currentNoteId;
        method = 'PUT';
    }

    $.ajax({
        url: url,
        method: method,
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function (response) {
            if (response.success) {
                showToast(response.message, 'success');
                closeSaveModal();
                currentNoteId = response.data.id;
            }
        },
        error: function (xhr) {
            var message = 'Error saving note';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            showToast(message, 'error');
        }
    });
}

function loadNotesFromServer(filters) {
    filters = filters || {};

    var params = new URLSearchParams(filters).toString();
    var url = '/api/notes' + (params ? '?' + params : '');

    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                displayNotesList(response.data.data);
            }
        },
        error: function (xhr) {
            showToast('Error loading notes', 'error');
        }
    });
}

function displayNotesList(notes) {
    var $container = $('#notesListContainer');
    $container.empty();

    if (notes.length === 0) {
        $container.html(
            '<div class="text-center py-12 text-gray-400">' +
            '<i class="fas fa-folder-open text-5xl mb-3"></i>' +
            '<p>No notes found</p>' +
            '</div>'
        );
        return;
    }

    $.each(notes, function (index, note) {
        var componentsList = '';
        if (note.components_used && note.components_used.length > 0) {
            componentsList = note.components_used.slice(0, 3).join(', ');
            if (note.components_used.length > 3) {
                componentsList += '...';
            }
        }

        var $noteCard = $('<div>')
            .addClass('bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer')
            .html(
                '<div class="flex items-start justify-between mb-2">' +
                '<div class="flex-1">' +
                '<h3 class="font-bold text-gray-800 text-lg mb-1">' + note.topic + '</h3>' +
                (note.sub_topic ? '<p class="text-sm text-blue-600 mb-2">' + note.sub_topic + '</p>' : '') +
                '</div>' +
                '<span class="text-xs text-gray-500">' + new Date(note.created_at).toLocaleDateString() + '</span>' +
                '</div>' +
                (note.description ? '<p class="text-sm text-gray-600 mb-3">' + note.description + '</p>' : '') +
                '<div class="flex items-center justify-between text-xs text-gray-500">' +
                '<span><i class="fas fa-puzzle-piece mr-1"></i>' + note.component_count + ' components</span>' +
                (componentsList ? '<span class="text-xs text-gray-400">' + componentsList + '</span>' : '') +
                '</div>' +
                '<div class="mt-3 flex gap-2">' +
                '<button class="load-note-btn flex-1 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm" data-id="' + note.id + '">' +
                '<i class="fas fa-download mr-1"></i>Load' +
                '</button>' +
                '<button class="delete-note-btn px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm" data-id="' + note.id + '">' +
                '<i class="fas fa-trash"></i>' +
                '</button>' +
                '</div>'
            );

        $container.append($noteCard);
    });

    // Load note button
    $(document).on('click', '.load-note-btn', function () {
        var noteId = $(this).data('id');
        loadNoteById(noteId);
    });

    // Delete note button
    $(document).on('click', '.delete-note-btn', function () {
        var noteId = $(this).data('id');
        deleteNoteById(noteId);
    });
}

function loadNoteById(noteId) {
    $.ajax({
        url: '/api/notes/' + noteId,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                var note = response.data;

                // Load content into canvas
                $('#canvas').html(note.content);
                $('#emptyState').remove();

                currentNoteId = note.id;
                closeLoadModal();
                showToast('Note loaded: ' + note.topic, 'success');
            }
        },
        error: function (xhr) {
            showToast('Error loading note', 'error');
        }
    });
}

function deleteNoteById(noteId) {
    if (!confirm('Are you sure you want to delete this note?')) {
        return;
    }

    $.ajax({
        url: '/api/notes/' + noteId,
        method: 'DELETE',
        success: function (response) {
            if (response.success) {
                showToast(response.message, 'success');
                loadNotesFromServer();
            }
        },
        error: function (xhr) {
            showToast('Error deleting note', 'error');
        }
    });
}