jQuery(document).ready(function($) {
    var file_frame;
    var current_input_field; // To store the current input field for file URL

    // Handle file upload button click
    $(document).on('click', '.royal-upload-button', function(event) {
        event.preventDefault();

        current_input_field = $(this).prev('.royal-font-file-url');
        var file_type = $(this).data('file-type'); // Get the specific file type

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media({
            title: royalFontAdmin.i18n.selectFontTitle,
            button: {
                text: royalFontAdmin.i18n.useFontButton,
            },
            multiple: false, // Set to true to allow multiple files
            library: {
                // Filter media by type based on the button clicked
                type: royalFontAdmin.allowedFileTypes[file_type],
            },
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            current_input_field.val(attachment.url);
            // Add remove button if it doesn't exist
            if (current_input_field.nextAll('.royal-remove-button').length === 0) {
                $('<button type="button" class="button button-secondary royal-remove-button">Remove</button>').insertAfter(current_input_field.next('.royal-upload-button'));
            }
        });

        // Open the media frame.
        file_frame.open();
    });

    // Handle remove file button click
    $(document).on('click', '.royal-remove-button', function() {
        $(this).prevAll('.royal-font-file-url').val(''); // Clear the input field
        $(this).remove(); // Remove the button itself
    });

    // Handle adding new font row
    $('#royal-add-font-row').on('click', function() {
        var $tbody = $('.royal-font-table tbody');
        var $template = $('#royal-font-row-template').html();
        var newIndex = $tbody.find('.royal-font-row').length;
        var $newRow = $($template.replace(/__INDEX__/g, newIndex));
        $tbody.append($newRow);
    });

    // Handle removing a font row
    $(document).on('click', '.royal-remove-row', function() {
        if (confirm('Are you sure you want to remove this font variant?')) {
            $(this).closest('.royal-font-row').remove();
            // Re-index rows after removal
            $('.royal-font-table tbody tr.royal-font-row').each(function(index) {
                $(this).find('[name^="royal_font_data"]').each(function() {
                    var oldName = $(this).attr('name');
                    var newName = oldName.replace(/\[\d+\]/, '[' + index + ']');
                    $(this).attr('name', newName);
                });
            });
        }
    });
});