$(function () {
    $('select').on('change', function () {
        let key = $(this).attr('name');
        let value = $(this).val();

        $.ajax({
            type: 'GET',
            url: '/ajax-filter',
            data: key + '=' + value,
            success: function (result) {
                $('.cards_block').html(result);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});
