$(document).ready(function()
{
    var mijnSelectie = 0;

    $("input[name='factuur_selectie']:radio").change(function()
    {
        if (this.value == 1) {
            mijnSelectie = 1;
            $(".printbtn").attr("href","print-facturen?optionID=1");
        }
        else if (this.value == 2) {
            mijnSelectie = 2;
            $(".printbtn").attr("href","print-facturen?optionID=2");
        }
        else if (this.value == 3) {
            mijnSelectie = 3;
            $(".printbtn").attr("href","print-facturen?optionID=3");
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        $.post("search/executeFacturenSearch", {keywords: mijnSelectie}).done(function (data) {
            $('#search-results').html(data)
        });
    });

    $('.voldaan_check').click(function() {
        if ($(this).is(':checked')) {
            var choice = confirm("Als je het factuur op voldaan zet, zal ik het betaald bedrag gelijk zetten aan het totale bedrag. Bent u akkoord ?");

            if (choice) {
                $('.betaald').val($('input[name=bedrag]').val());
                //$('.betaald').val($('.bedrag').val());
            }
            else
            {
                return false;
            }
        }
    });

/*
    $(".printbtn").click(function(e)
    {
        var option = $("input[name='factuur_selectie']:checked").val();

        $.ajax({
            type: 'POST',
            url: 'print-facturen',
            data: {"optionID": option}
        })
    });
*/
});




