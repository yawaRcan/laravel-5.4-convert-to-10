var timer;

function up() {
    timer = setTimeout(function () {
        var keywords = $('#search-input').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        if (keywords.length > 0) {
            $.post("search/executeSearch", {keywords: keywords}).done(function (data) {
                console.log(data)
                $('#search-results').html(data)
            });
        }
    }, 500);
}

function down() {
    clearTimeout(timer);
}

function upDossiers() {
    timer = setTimeout(function () {
        var keywords = $('#search-input').val();

        if (keywords.length > 0) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            $.post("search/executeSearchDossiers", {keywords: keywords}).done(function (data) {
                console.log(data)
                $('#search-results').html(data)
            });
        }
    }, 500);
}

function downDossiers() {
    clearTimeout(timer);
}