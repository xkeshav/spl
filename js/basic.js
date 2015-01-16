$(function() {
    $.datepicker.setDefaults({
        // showOn: "focus",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'D, M d, yy',
        showButtonPanel: true,
        // maxDate: "+1m +1w",
        autoOpen: true,
        maxDate: new Date()
    });

    $("#dialog").dialog({
        autoOpen: false,
        width: 500,
        height: 600
    });

    $("#button").on("click", function() {
        $("#dialog").dialog("open");
    });

    // Link to open the dialog
    $("#dialog-link").on('click', function(event) {
        $("#dialog").dialog("open");
        event.preventDefault();
    });



    // $("#datepicker").datepicker({
    //     onSelect: function(date, obj) {
    //         $('#date_input').val(date);
    //         inline: true;
    //     }
    // });

    var date = new Date();

    var day = date.getDate();
    var months = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    // var gm = $("#datepicker").datepicker().getMonth();
    // console.log(gm);
    var month = months[11];
    var year = date.getFullYear();

    if (day < 10) day = "0" + day;

    var today = month + " " + day + ", " + year;
    $("#date_input").attr("value", today);

    $(".date").datepicker({
        onSelect: function(dateText) {
            $(this).change();
        }
    })
        .change(function() {
            display("Date field changed: " + this.value);
        });

    function display(msg) {
        $("<p>").php(msg).appendTo(document.body);
    }

    var name = "John Smith";

    $("#name").text(name);

    // Hover states on the static widgets
    $("#dialog-link, #icons li").hover(
        function() {
            $(this).addClass("ui-state-hover");
        },
        function() {
            $(this).removeClass("ui-state-hover");
        });

    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        // showButtonPanel: true,
        dateFormat: 'MM yy',
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker('getDate'),
                day = date.getDate(),
                month = date.getMonth() + 1,
                year = date.getFullYear();
            // alert(day + '-' + month + '-' + year);
        },
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});