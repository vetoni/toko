(function ($) {
    $(document).ready(function() {
        var container = $('.currencies');
        $('a', container).on('click', function(e) {
            e.preventDefault();
            $.post(container.attr('data-action'), {code: $(this).attr('data-id')}, function() {
                window.location.reload();
            });
        });
    });
})(jQuery);