function zoekFacturen() {

    var criterium = $('input[name=criterium]:checked').val();

    if (criterium == 1) {

        var startnr = $('input[name=factuurnr_start]').val();
        var eindnr = $('input[name=factuurnr_einde]').val();

        if (startnr == '' || eindnr == '') {
            alert('Gelieve beide factuur nummers in te geven!');
            return;
        }
    }
    else if (criterium == 2) {
        var factuurdatum_start = $('input[name=factuurdatum_start]').val();
        var factuurdatum_einde = $('input[name=factuurdatum_einde]').val();

        if (factuurdatum_start == '' || factuurdatum_einde == '') {
            alert('Gelieve beide factuur data in te geven!');
            return;
        }
        else {
            dt1 = new Date(factuurdatum_start);
            dt2 = new Date(factuurdatum_einde);
            if (dt1 > dt2) {
                alert('Begindatum is LATER dan de einddatum. Gelieve dit in orde te brengen!');
                return;
            }
        }
    }
    else
        criterium = 0;

    var myData = [
        {
            "criterium": criterium,
            "startnr": $('input[name=factuurnr_start]').val(),
            "eindnr": $('input[name=factuurnr_einde]').val(),
            "factuurdatum_start": $('input[name=factuurdatum_start]').val(),
            "factuurdatum_einde": $('input[name=factuurdatum_einde]').val(),
            "bedrag": $('input[name=bedrag]').val(),
            "operator": $("#operator").val(),
            "klant_id": $("#klant_id").val(),
            "makelaar_id": $("#makelaar_id").val(),
            "selectie": $('input[name=facturen_selectie]:checked').val(),
            "sortering": $('input[name=facturen_sortering]:checked').val()
        }
    ];
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $.post('search/searchInvoices', {data: myData}).done(function (data) {
        $('#search-results').html(data)
    });
}

function berekenen() {

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
    $.post('search/statistieken', {data: myData}).done(function (data) {
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