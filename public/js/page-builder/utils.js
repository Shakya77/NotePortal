$(document).ready(function () {
    initializeUtils();
});

function initializeUtils() {
    // Preview button
    $('#previewBtn').on('click', function () {
        togglePreview();
    });

    // Close preview button
    $('#closePreviewBtn').on('click', function () {
        togglePreview();
    });

    // Export button
    $('#exportBtn').on('click', function () {
        exportHTML();
    });

    // Close toast button
    $('#closeToastBtn').on('click', function () {
        hideToast();
    });
}

function togglePreview() {
    var $modal = $('#previewModal');

    if ($modal.hasClass('hidden')) {
        // Clone and clean
        var $clone = $('#canvas').clone();
        $clone.find('.action-buttons').remove();
        $clone.find('.component-wrapper').removeClass().addClass('mb-4');
        $clone.find('input').remove();
        $clone.find('#emptyState').remove();

        $('#previewContent').html($clone.html());
        $modal.removeClass('hidden');
    } else {
        $modal.addClass('hidden');
    }
}

function exportHTML() {
    var $clone = $('#canvas').clone();

    // Clean up
    $clone.find('.action-buttons').remove();
    $clone.find('.component-wrapper').removeClass().addClass('mb-4');
    $clone.find('input').remove();
    $clone.find('#emptyState').remove();

    var html = '<!DOCTYPE html>\n' +
        '<html lang="en">\n' +
        '<head>\n' +
        '    <meta charset="UTF-8">\n' +
        '    <meta name="viewport" content="width=device-width, initial-scale=1.0">\n' +
        '    <title>Exported Page</title>\n' +
        '    <script src="https://cdn.tailwindcss.com"></script>\n' +
        '    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">\n' +
        '</head>\n' +
        '<body class="bg-white p-8">\n' +
        '    <div class="max-w-6xl mx-auto">\n' +
        $clone.html() + '\n' +
        '    </div>\n' +
        '</body>\n' +
        '</html>';

    // Download
    var blob = new Blob([html], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'page-' + Date.now() + '.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);

    showToast('HTML exported successfully!', 'success');
}

function showToast(message, type) {
    type = type || 'success';

    var $toast = $('#toast');
    var $icon = $('#toastIcon');
    var $message = $('#toastMessage');

    // Set icon based on type
    if (type === 'success') {
        $icon.removeClass().addClass('fas fa-check-circle text-green-500 text-2xl');
        $toast.removeClass('border-red-500 border-blue-500').addClass('border-green-500');
    } else if (type === 'error') {
        $icon.removeClass().addClass('fas fa-exclamation-circle text-red-500 text-2xl');
        $toast.removeClass('border-green-500 border-blue-500').addClass('border-red-500');
    } else if (type === 'info') {
        $icon.removeClass().addClass('fas fa-info-circle text-blue-500 text-2xl');
        $toast.removeClass('border-green-500 border-red-500').addClass('border-blue-500');
    }

    $message.text(message);
    $toast.removeClass('hidden fade-out');

    setTimeout(function () {
        $toast.addClass('fade-out');
        setTimeout(function () {
            $toast.addClass('hidden');
        }, 300);
    }, 3000);
}

function hideToast() {
    var $toast = $('#toast');
    $toast.addClass('fade-out');
    setTimeout(function () {
        $toast.addClass('hidden');
    }, 300);
}