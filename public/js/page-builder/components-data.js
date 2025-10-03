// Global variables
var componentsData = [];
var draggedComponentId = null;
var componentCounter = 0;

// Initialize components data
componentsData = [
    {
        id: 'heading',
        name: 'Heading',
        icon: 'fa-heading',
        color: 'blue',
        category: 'text',
        html: '<h2 class="text-4xl font-bold text-gray-800 mb-4" contenteditable="true">Your Heading Here</h2>'
    },
    {
        id: 'subheading',
        name: 'Subheading',
        icon: 'fa-heading',
        color: 'indigo',
        category: 'text',
        html: '<h3 class="text-2xl font-semibold text-gray-700 mb-3" contenteditable="true">Your Subheading Here</h3>'
    },
    {
        id: 'paragraph',
        name: 'Paragraph',
        icon: 'fa-paragraph',
        color: 'green',
        category: 'text',
        html: '<p class="text-base text-gray-600 leading-relaxed mb-4" contenteditable="true">This is a paragraph. Click to edit this text and add your own content. You can write as much as you need.</p>'
    },
    {
        id: 'button',
        name: 'Button',
        icon: 'fa-hand-pointer',
        color: 'cyan',
        category: 'interactive',
        html: '<button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition mb-4" contenteditable="true">Click Me</button>'
    },
    {
        id: 'image',
        name: 'Image',
        icon: 'fa-image',
        color: 'purple',
        category: 'media',
        html: '<div class="mb-4"><img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=400&fit=crop" alt="Sample" class="w-full h-auto rounded-lg shadow-md mb-2"><input type="text" placeholder="Enter image URL" class="w-full px-3 py-2 border border-gray-300 rounded text-sm image-url-input"></div>'
    },
    {
        id: 'video',
        name: 'Video',
        icon: 'fa-video',
        color: 'red',
        category: 'media',
        html: '<div class="mb-4"><div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center mb-2 video-placeholder"><i class="fas fa-play-circle text-6xl text-gray-400"></i></div><input type="text" placeholder="YouTube embed URL" class="w-full px-3 py-2 border border-gray-300 rounded text-sm video-url-input"></div>'
    },
    {
        id: 'code',
        name: 'Code Block',
        icon: 'fa-code',
        color: 'yellow',
        category: 'content',
        html: '<div class="mb-4"><div class="bg-gray-900 rounded-lg overflow-hidden"><div class="bg-gray-800 px-4 py-2 flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-red-500"></div><div class="w-3 h-3 rounded-full bg-yellow-500"></div><div class="w-3 h-3 rounded-full bg-green-500"></div><span class="ml-2 text-xs text-gray-400">code.js</span></div><pre class="p-4"><code class="text-green-400 text-sm" contenteditable="true">// Your code here\nfunction hello() {\n    console.log("Hello World!");\n}</code></pre></div></div>'
    },
    {
        id: 'list',
        name: 'List',
        icon: 'fa-list-ul',
        color: 'teal',
        category: 'text',
        html: '<ul class="list-disc list-inside space-y-2 text-gray-700 mb-4"><li contenteditable="true">First list item</li><li contenteditable="true">Second list item</li><li contenteditable="true">Third list item</li></ul>'
    },
    {
        id: 'card',
        name: 'Card',
        icon: 'fa-id-card',
        color: 'pink',
        category: 'content',
        html: '<div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition mb-4"><h3 class="text-xl font-bold text-gray-800 mb-2" contenteditable="true">Card Title</h3><p class="text-gray-600 mb-4" contenteditable="true">This is a card component with some content inside.</p><button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm" contenteditable="true">Learn More</button></div>'
    },
    {
        id: 'alert',
        name: 'Alert Box',
        icon: 'fa-exclamation-triangle',
        color: 'amber',
        category: 'content',
        html: '<div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-4"><div class="flex items-start"><i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i><div class="flex-1"><h4 class="font-semibold text-blue-800 mb-1" contenteditable="true">Information</h4><p class="text-blue-700 text-sm" contenteditable="true">This is an alert message. You can customize it.</p></div></div></div>'
    },
    {
        id: 'quote',
        name: 'Quote',
        icon: 'fa-quote-left',
        color: 'violet',
        category: 'text',
        html: '<blockquote class="border-l-4 border-gray-400 pl-4 py-2 italic text-gray-700 mb-4"><p class="text-lg mb-2" contenteditable="true">"This is a quote. Click to edit."</p><footer class="text-sm text-gray-500" contenteditable="true">— Author Name</footer></blockquote>'
    },
    {
        id: 'divider',
        name: 'Divider',
        icon: 'fa-minus',
        color: 'gray',
        category: 'layout',
        html: '<hr class="my-6 border-t-2 border-gray-200">'
    },
    {
        id: 'spacer',
        name: 'Spacer',
        icon: 'fa-arrows-alt-v',
        color: 'slate',
        category: 'layout',
        html: '<div class="h-12"></div>'
    },
    {
        id: 'section',
        name: 'Section Container',
        icon: 'fa-square',
        color: 'orange',
        category: 'layout',
        html: '<div class="droppable-zone border-2 border-dashed border-gray-300 rounded-lg p-6 mb-4 bg-gray-50"><h3 class="text-lg font-semibold text-gray-500 mb-2" contenteditable="true">Section Container</h3><p class="text-sm text-gray-400">Drop components here</p></div>'
    },
    {
        id: 'columns-2',
        name: '2 Columns',
        icon: 'fa-columns',
        color: 'sky',
        category: 'layout',
        html: '<div class="grid grid-cols-2 gap-4 mb-4"><div class="droppable-zone border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[150px]"><p class="text-sm text-gray-400">Column 1</p></div><div class="droppable-zone border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[150px]"><p class="text-sm text-gray-400">Column 2</p></div></div>'
    },
    {
        id: 'columns-3',
        name: '3 Columns',
        icon: 'fa-th',
        color: 'rose',
        category: 'layout',
        html: '<div class="grid grid-cols-3 gap-4 mb-4"><div class="droppable-zone border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[120px]"><p class="text-xs text-gray-400">Col 1</p></div><div class="droppable-zone border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[120px]"><p class="text-xs text-gray-400">Col 2</p></div><div class="droppable-zone border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[120px]"><p class="text-xs text-gray-400">Col 3</p></div></div>'
    },
    {
        id: 'table',
        name: 'Table',
        icon: 'fa-table',
        color: 'emerald',
        category: 'content',
        html: '<div class="overflow-x-auto mb-4"><table class="min-w-full border border-gray-200 rounded-lg"><thead class="bg-gray-100"><tr><th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700" contenteditable="true">Header 1</th><th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700" contenteditable="true">Header 2</th><th class="px-4 py-2 border-b text-left text-sm font-semibold text-gray-700" contenteditable="true">Header 3</th></tr></thead><tbody><tr class="hover:bg-gray-50"><td class="px-4 py-2 border-b text-sm text-gray-600" contenteditable="true">Data 1</td><td class="px-4 py-2 border-b text-sm text-gray-600" contenteditable="true">Data 2</td><td class="px-4 py-2 border-b text-sm text-gray-600" contenteditable="true">Data 3</td></tr><tr class="hover:bg-gray-50"><td class="px-4 py-2 border-b text-sm text-gray-600" contenteditable="true">Data 4</td><td class="px-4 py-2 border-b text-sm text-gray-600" contenteditable="true">Data 5</td><td class="px-4 py-2 border-b text-sm text-gray-600" contenteditable="true">Data 6</td></tr></tbody></table></div>'
    }
];

// Load components into sidebar
$(document).ready(function () {
    loadComponentsList();
    console.log('Page Builder initialized with ' + componentsData.length + ' components');
});

function loadComponentsList() {
    var $container = $('#componentsList');
    $container.empty();

    $.each(componentsData, function (index, component) {
        var $div = $('<div>')
            .addClass('component-item bg-' + component.color + '-50 border-2 border-' + component.color + '-200 rounded-lg p-3 mb-2 hover:bg-' + component.color + '-100 hover:border-' + component.color + '-300 transition-all flex items-center gap-3 shadow-sm')
            .attr('draggable', 'true')
            .attr('data-component-id', component.id)
            .attr('data-component-name', component.name.toLowerCase())
            .attr('data-component-category', component.category);

        var html = '<div class="w-10 h-10 bg-' + component.color + '-200 rounded-lg flex items-center justify-center">' +
            '<i class="fas ' + component.icon + ' text-' + component.color + '-700 text-lg"></i>' +
            '</div>' +
            '<div class="flex-1">' +
            '<p class="text-sm font-semibold text-gray-800">' + component.name + '</p>' +
            '<p class="text-xs text-gray-500 capitalize">' + component.category + '</p>' +
            '</div>' +
            '<i class="fas fa-grip-vertical text-gray-400"></i>';

        $div.html(html);
        $container.append($div);
    });

    console.log('Loaded ' + componentsData.length + ' components into sidebar');
}