
function getItem(id){
    $('#time').text(id.value);
    console.log(id.value)
}
function getCartTime(id){
    $('#time').text(id.value);
    console.log(id.value)
}


function getReportDay(id){
    $('#reportday_id').text(id);
    console.log(id)
}

$(function () {
    $('#cart_heure').append("<p>Aucune horaire pour cette date</p>")
    $("#calenda_week").hide()
    $("#calenda_day").hide()
    $("#calenda_month").show()
    var datet=$("#date_start").val();
    function selectDate(date) {
        $('#calendar-wrapper').updateCalendarOptions({
            date: date
        });
        //  console.log(calendar.getSelectedDate());
        const datev = new Date(calendar.getSelectedDate());
        console.log(formatDate(datev))
        $('#fixture_date').val(formatDate(datev))
        datet=formatDate(datev);
        $.ajax({
            url: configs.routes.calculplaning,
            type: "GET",
            dataType: "JSON",
            data: {
                'user_id': $("input[name='flexpersonnel']:checked").val(),
                'item':$('#soin_id').text(),
                'date':datet
            },
            success: function (data) {

                $('#cart_heure').html('')
                if(data.data.length<1){
                    $('#cart_heure').append("<p>Aucune horaire pour cette date</p>")
                }
                $.each(data.data, function (index, item) {
                    var item_=item;
                   //$('#cart_heure').append("<button onclick='getItem("+item_+");' class='btn btn-outline-dark btn-sm m-1'>"+item+"</a>")
                    $('#cart_heure').append('<input onclick="getCartTime(this)" type="button" class="btn btn-outline-success btn-sm m-1" value="'+item+'"/>')
                })

            },
            error: function (err) {
                alert("An error ocurred while loading data ...");
            }
        });
        //window.location=configs.routes.index+"?date_start="+datet;
    }
    var current_Date=new Date();
    var defaultConfig = {
        weekDayLength: 1,
        date: datet,
        onClickDate: selectDate,
        showYearDropdown: true,
        startOnMonday: true,
        min:new Date(current_Date+1)
    };

    var calendar = $('#calendar-wrapper').calendar(defaultConfig);
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
$('#delete_btn').click(function () {
    $.ajax({
        url: configs.routes.ajaxdeleteperiode,
        type: "GET",
        dataType: "JSON",
        data: {
          'item':$('#periode_id').text()
        },
        success: function (data) {
            window.location.reload(true);
        },
        error: function (err) {
            alert("An error ocurred while loading data ...");
        }
    });
})
    $('#delete_btn_conge').click(function () {
        $.ajax({
            url: configs.routes.ajaxdeleteconge,
            type: "GET",
            dataType: "JSON",
            data: {
                'item':$('#periode_id').text()
            },
            success: function (data) {
                window.location.reload(true);
            },
            error: function (err) {
                alert("An error ocurred while loading data ...");
            }
        });
    })
    $('#confirm_btn_calandar').click(function () {
        $.ajax({
            url: configs.routes.reportcalandar,
            type: "GET",
            dataType: "JSON",
            data: {
                'item':$('#reportday_id').text()
            },
            success: function (data) {
                console.log(data)
                if (data.status===200){
                    window.location.reload(true);
                }else {
                    alert(data.data);
                }

            },
            error: function (err) {
                console.log(err)
                alert("An error ocurred while loading data ...");
                //window.location.reload(true);
            }
        });
    })
    $('#selectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });
    $('#send_mail').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        jsonObj = [];
        $("#table_user>tbody input[type=checkbox]:checked").each(function () {
            var row = $(this).closest('tr')[0];
            var id = row.cells[1].innerText;
            item = {};
            item['id'] = id;
            jsonObj.push(item)
        });
        console.log(JSON.stringify({data: jsonObj}))
        $.ajax({
            url: configs.routes.sendmail,
            type: "POST",
            dataType: "JSON",
            data: JSON.stringify({
                ob: jsonObj,subject:$('#subject').val(),message:$('#message_mail').val()
            }),
            success: function (data) {
                window.location.reload(true);
            },
            error: function (err) {
                console.log(err)
                alert("An error ocurred while loading data ..."+err.responseJSON.message);
            }
        });
    })
})

