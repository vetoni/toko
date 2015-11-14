(function ($) {
    $(document).ready(function() {
        var container = $('.currencies');
        $('a', container).on('click', function(e) {
            e.preventDefault();
            $.post(container.attr('data-action'), {code: $(this).attr('data-id')}, function() {
                window.location.reload();
            });
        });

        $("#product_comments").on("pjax:end", function() {
            $.pjax.reload({container:"#product_avg_rating", "timeout" : 10000});
        });

        $(".btn-clear-cache").on('click', function(e) {
            e.preventDefault();
            var link = $(this);
            $.post(link.attr('data-action'), function() {
                alert(link.attr('data-message'));
            });
        });
    });
})(jQuery);