function berekenen() {
    console.log('click');

    $startjaar = $('input[name=startjaar]').val();
    $eindjaar = $('input[name=eindjaar]').val();

    if (yearValidation($startjaar) && yearValidation($eindjaar)) {

        if ($startjaar == '' || $eindjaar == '') {
            alert('Gelieve begin- en eindjaar in te geven!');
            return;
        }
        else if ($startjaar > $eindjaar) {
            alert('Het eindjaar is VOOR het start jaar. Gelieve dit aan te passen!');
            return;
        }
    }
    else
    {
        return false;
    }

    var myData = [
        {
            "criterium": $('input[name=criterium]:checked').val(),
            "startjaar": $startjaar,
            "eindjaar": $eindjaar,
        }
    ];
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $.post('search/dossiersstatistieken', {data: myData}).done(function (data) {
        $('#search-results').html(data)
    });

}

function yearValidation(year) {
    var text = /^[0-9]+$/;

    if (year == "") {
        alert('Gelieve begin- en eindjaar in te geven!')
        return false;
    }

    if (year != 0) {

        if ((year != "") && (!text.test(year))) {
            alert("Enkel cijfers ingeven a.u.b.!");
            return false;
        }

        if (year.length != 4) {
            alert("Jaartal is niet correct ingegeven.");
            return false;
        }

        var current_year = new Date().getFullYear();
        if ((year < 1920) || (year > current_year)) {
            alert("Jaartal moet tussen 1920 en " + current_year);
            return false;
        }
        return true;
    }
}