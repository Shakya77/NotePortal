$(document).ready(function () {
    initializeActions();
});

function initializeActions() {
    // Move up
    $(document).on('click', '.move-up-btn', function (e) {
        e.stopPropagation();
        var $wrapper = $(this).closest('.component-wrapper');
        var $prev = $wrapper.prev('.component-wrapper');
        if ($prev.length) {
            $wrapper.insertBefore($prev);
            showToast('Moved up', 'info');
        }
    });

    // Move down
    $(document).on('click', '.move-down-btn', function (e) {
        e.stopPropagation();
        var $wrapper = $(this).closest('.component-wrapper');
        var $next = $wrapper.next('.component-wrapper');
        if ($next.length) {
            $wrapper.insertAfter($next);
            showToast('Moved down', 'info');
        }
    });

    // Duplicate
    $(document).on('click', '.duplicate-btn', function (e) {
        e.stopPropagation();
        var $wrapper = $(this).closest('.component-wrapper');
        var $clone = $wrapper.clone(true);
        componentCounter++;
        $clone.attr('data-component-id', componentCounter);
        $wrapper.after($clone);
        showToast('Component duplicated', 'success');
    });

    // Delete
    $(document).on('click', '.delete-btn', function (e) {
        e.stopPropagation();
        if (confirm('Delete this component?')) {
            var $wrapper = $(this).closest('.component-wrapper');
            $wrapper.remove();

            // Check if canvas is empty
            if ($('#canvas .component-wrapper').length === 0) {
                $('#canvas').html(
                    '<div id="emptyState" class="text-center py-20">' +
                    '<div class="inline-block p-6 bg-blue-50 rounded-full mb-4">' +
                    '<i class="fas fa-mouse-pointer text-5xl text-blue-500"></i>' +
                    '</div>' +
                    '<h3 class="text-2xl font-bold text-gray-700 mb-2">Start Building Your Page</h3>' +
                    '<p class="text-gray-500 mb-6">Drag components from the left sidebar and drop them here</p>' +
                    '<div class="flex gap-3 justify-center">' +
                    '<div class="text-center">' +
                    '<div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">' +
                    '<i class="fas fa-hand-pointer text-blue-600 text-xl"></i>' +
                    '</div>' +
                    '<p class="text-xs text-gray-600">Drag</p>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">' +
                    '<i class="fas fa-arrow-right text-green-600 text-xl"></i>' +
                    '</div>' +
                    '<p class="text-xs text-gray-600">Drop</p>' +
                    '</div>' +
                    '<div class="text-center">' +
                    '<div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">' +
                    '<i class="fas fa-edit text-purple-600 text-xl"></i>' +
                    '</div>' +
                    '<p class="text-xs text-gray-600">Edit</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
            }

            showToast('Component deleted', 'success');
        }
    });

    // Search components
    $('#searchInput').on('keyup', function () {
        var query = $(this).val().toLowerCase();

        $('.component-item').each(function () {
            var name = $(this).data('component-name');
            var category = $(this).data('component-category');

            if (name.includes(query) || category.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Clear canvas
    $('#clearBtn').on('click', function () {
        if (confirm('Clear all components from canvas?')) {
            $('#canvas').html(
                '<div id="emptyState" class="text-center py-20">' +
                '<div class="inline-block p-6 bg-blue-50 rounded-full mb-4">' +
                '<i class="fas fa-mouse-pointer text-5xl text-blue-500"></i>' +
                '</div>' +
                '<h3 class="text-2xl font-bold text-gray-700 mb-2">Start Building Your Page</h3>' +
                '<p class="text-gray-500 mb-6">Drag components from the left sidebar and drop them here</p>' +
                '<div class="flex gap-3 justify-center">' +
                '<div class="text-center">' +
                '<div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">' +
                '<i class="fas fa-hand-pointer text-blue-600 text-xl"></i>' +
                '</div>' +
                '<p class="text-xs text-gray-600">Drag</p>' +
                '</div>' +
                '<div class="text-center">' +
                '<div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">' +
                '<i class="fas fa-arrow-right text-green-600 text-xl"></i>' +
                '</div>' +
                '<p class="text-xs text-gray-600">Drop</p>' +
                '</div>' +
                '<div class="text-center">' +
                '<div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">' +
                '<i class="fas fa-edit text-purple-600 text-xl"></i>' +
                '</div>' +
                '<p class="text-xs text-gray-600">Edit</p>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
            showToast('Canvas cleared', 'success');
        }
    });
}