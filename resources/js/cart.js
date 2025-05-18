// Remove this wrapper:
// (function($) { ... })(jQuery);

// Use this instead:
$(document).ready(function() {
    // Update quantity
    $(document).on('change', '.item-quantity', function(e) {
        $.ajax({
            url: `/cart/${$(this).data('id')}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                quantity: $(this).val()
            },
            success: () => {
                window.location.reload(); // Force refresh to get updated data
            }
        });
    });

    // Remove item
    $(document).on('click', '.remove-item', function(e) {
        let id = $(this).data('id');
        $.ajax({
            url: `/cart/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: response => {
                $(`#${id}`).remove();
            }
        });
    });
});
