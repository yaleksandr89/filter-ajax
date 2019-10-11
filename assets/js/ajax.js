$(function () {
    $('select').on('change', function () {
        let key = $(this).attr('name');
        let value = $(this).val();

        $.ajax({
            type: 'get',
            url: 'app/helper/ajax-filter.php',
            data: key + '=' + value,
            success: function (result) {
                $('.cards_block').html(result);
            },
            error: function () {
                alert('Ajax error =(');
            }
        });
    });
});