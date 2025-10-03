$(document).ready(function () {
    initializeDragAndDrop();
});

function initializeDragAndDrop() {
    // Component drag start
    $(document).on('dragstart', '.component-item', function (e) {
        draggedComponentId = $(this).data('component-id');
        $(this).addClass('dragging');
        e.originalEvent.dataTransfer.effectAllowed = 'copy';
        e.originalEvent.dataTransfer.setData('text/html', 'component');
        console.log('Started dragging: ' + draggedComponentId);
    });

    // Component drag end
    $(document).on('dragend', '.component-item', function (e) {
        $(this).removeClass('dragging');
        console.log('Ended dragging');
    });

    // Canvas and droppable zones - drag over
    $(document).on('dragover', '#canvas, .droppable-zone', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.originalEvent.dataTransfer.dropEffect = 'copy';
        $(this).addClass('drag-over');
    });

    // Canvas and droppable zones - drag leave
    $(document).on('dragleave', '#canvas, .droppable-zone', function (e) {
        $(this).removeClass('drag-over');
    });

    // Canvas and droppable zones - drop
    $(document).on('drop', '#canvas, .droppable-zone', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('drag-over');

        if (!draggedComponentId) {
            console.log('No component being dragged');
            return;
        }

        // Find the component data
        var component = componentsData.find(function (c) {
            return c.id === draggedComponentId;
        });

        if (!component) {
            console.log('Component not found: ' + draggedComponentId);
            return;
        }

        console.log('Dropping component: ' + component.name);

        // Remove empty state if it exists
        $('#emptyState').remove();

        // Create wrapper
        componentCounter++;
        var $wrapper = $('<div>')
            .addClass('component-wrapper bg-white rounded-lg p-3 mb-3 border border-gray-200 hover:border-blue-400 transition-all relative')
            .attr('data-component-id', componentCounter)
            .attr('data-component-type', component.id);

        // Add component HTML
        var actionButtons = '<div class="action-buttons absolute top-2 right-2 bg-white rounded-lg shadow-lg border border-gray-200 p-1 flex gap-1">' +
            '<button class="move-up-btn w-8 h-8 hover:bg-blue-50 rounded flex items-center justify-center text-gray-600 hover:text-blue-600 transition" title="Move Up">' +
            '<i class="fas fa-arrow-up text-xs"></i>' +
            '</button>' +
            '<button class="move-down-btn w-8 h-8 hover:bg-blue-50 rounded flex items-center justify-center text-gray-600 hover:text-blue-600 transition" title="Move Down">' +
            '<i class="fas fa-arrow-down text-xs"></i>' +
            '</button>' +
            '<button class="duplicate-btn w-8 h-8 hover:bg-green-50 rounded flex items-center justify-center text-gray-600 hover:text-green-600 transition" title="Duplicate">' +
            '<i class="fas fa-copy text-xs"></i>' +
            '</button>' +
            '<button class="delete-btn w-8 h-8 hover:bg-red-50 rounded flex items-center justify-center text-gray-600 hover:text-red-600 transition" title="Delete">' +
            '<i class="fas fa-trash text-xs"></i>' +
            '</button>' +
            '</div>';

        $wrapper.html(component.html + actionButtons);

        // Append to target
        var $dropTarget = $(e.currentTarget);
        if ($dropTarget.hasClass('droppable-zone')) {
            // Remove placeholder text
            $dropTarget.find('p.text-gray-400').first().remove();
            $dropTarget.append($wrapper);
        } else {
            $dropTarget.append($wrapper);
        }

        // Setup image URL input handler
        $wrapper.find('.image-url-input').on('change', function () {
            var url = $(this).val();
            if (url) {
                $(this).siblings('img').attr('src', url);
            }
        });

        // Setup video URL input handler
        $wrapper.find('.video-url-input').on('change', function () {
            var url = $(this).val();
            if (url) {
                var $placeholder = $(this).siblings('.video-placeholder');
                $placeholder.html('<iframe class="w-full h-full rounded-lg" src="' + url + '" frameborder="0" allowfullscreen></iframe>');
            }
        });

        showToast(component.name + ' added!', 'success');
        draggedComponentId = null;
    });
}