document.addEventListener('DOMContentLoaded', function() {
    let selects = document.querySelectorAll('select');

    selects.forEach(function(select) {
        select.addEventListener('change', function() {
            let key = this.getAttribute('name');
            let value = this.value;
            let query = new URLSearchParams({
                [key]: value
            });

            fetch('/ajax-filter?' + query.toString())
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Error when executing the request: ' + response.status);
                    }
                    return response.text();
                })
                .then(function(result) {
                    document.querySelector('[data-filters-block]').innerHTML = result;
                })
                .catch(function(error) {
                    console.error(error);
                });
        });
    });
});
