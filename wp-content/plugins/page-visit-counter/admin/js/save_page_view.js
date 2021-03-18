(function ($) {
    $(window).load(function () {
        if ($('.edit-post-header .components-button').length) {
            $('body').on('click', ".edit-post-header .components-button", function () {
                var post_ID = jQuery('#post_ID').val();
                $.ajax({
                    type: 'POST',
                    url: pagevisit.ajaxurl,
                    data: {
                        action: 'get_visit_page_result_after_update_admin',
                        page_id: post_ID
                    },
                    success: function (response) {
                        $('#total_page_visits_after_update span').html(response);
                    }
                });
            });
        }
    });
})(jQuery);