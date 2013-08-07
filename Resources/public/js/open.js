(function () {
    'use strict';

    $('.delete-file-btn').on('click', function(event){
        event.preventDefault();
        $.ajax({
            url: $(event.target).attr('href'),
            type: 'GET',
            success: function (workspaces) {
                $(event.target).parent().parent().remove();
            }
        });
    });
})();