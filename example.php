<?php namespace Directree\Example;
    require_once 'config.php';
    include_once 'header.php';
    require_once 'ProjectIterator.php';
    $obj_prj = new \Directree\ProjectIterator();
    $projectFolderDir = ARCHIVE.DS.'projectFoto';
    // $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7','s3', '201408');
    // get ALL screen /camera list of selected project and show on left panel dropdown
    $screenList = $obj_prj->getProjectScreenList($projectFolderDir);
    d($screenList);
?>
<div class="wrapper">
    <section id="left" >
        <figure id="thumb">
            <img src="<?php echo URL.'img/default.jpg'?>"width="100%" title="Current Thumb" />
        </figure>
        <!-- <div id="slider" width="300px"></div> -->
        <div id="screen">
            <select class="dropdown" id="selectedScreen">
                <option value="" selected disabled style="color:#000"  >Select Camera</option>
        <?php foreach ($screenList as $sc => $sv) {
                echo "<option value='$sc' title='$sc'>Camera $sc</option>";
        } // end o foreach ?>
                <!--   <option value="s2" title="s2">Camera s2</option> -->
            </select>
        </div>
        <div id="calendar"></div>
        <div id="timeSlot" style="margin-bottom:10px;">
        <!-- <div class="clickTime"><label>01:10:10</label><span>OK</span></div>  -->
        </div>
    </section>

   <section id="right" >
        <figure>
            <!-- <figurecaption>S3 DATE 14-10-2014 01:10:10</figurecaption> -->
            <img src="<?php echo URL.'img/default.jpg'?>" />
        </figure>
    </section>
</div>
<script>
var $ajax = false;
    $(function() {
    // $( "#slider" ).slider();
    var $location = window.location.protocol + '//' +  window.location.hostname ,
        $projectFolder = '<?=PROJECT_FOLDER?>',
        $projectBaseURL = $location + '/' + $projectFolder,
        $requestedFoto = {},
        $thumbList = {};
        $availMonth = {},
        $selectedScreen = false;
        //$no_ajax = false;
    var $mainImg =  $('section#right figure').children('img').eq(0),
        $thumbImg = $('section#left figure').children('img').eq(0);
    // console.log($projectBaseURL);
    //default setting for jquery ajax call
    $.ajaxSetup({
        url: $projectBaseURL + '/projects/rightscreen',
        global: false,
        type: 'POST',
        dataType: 'JSON',
        context: document.body,
        timeout: 30000, // timeout after 30 seconds
        beforeSend: function() {
            // console.dir($requestedFoto);
            $cameraEmpty = $.isEmptyObject($requestedFoto.selectedCamera);
            // console.log($cameraEmpty);
            // $no_ajax = $cameraEmpty;
            // console.log('NO_AJAX VALUE: ' + $no_ajax);
            // console.dir(xhr);
            return !$cameraEmpty
        }
    });
    // default setting for datepicker
    $.datepicker.setDefaults({
        minDate: '-12M',
        maxDate: 0,
        // dateFormat: 'D, M d, yy',
        // showOn: 'both',
        // buttonText: "Date",
        changeMonth: true,
        changeYear: true,
        gotoCurrent: false,
        showButtonPanel: false,
        disabled: false
    });

    // $('#calendar').datepicker().datepicker('disable');
    // get month list which ahve thumbnails
    $(document).on('change', '#selectedScreen', function() {
        // console.info('On Change Fired');
        $selectedScreen = $(this).val();
        $requestedFoto.selectedCamera = $selectedScreen;
        $.get( $projectBaseURL + "/projects/rightscreen", { screen: $selectedScreen } )
        .done(function(resp) {
            // store all availble months of selected screen scanning from directory folder
            // console.log(resp);
            $availMonth = resp;
            // console.info('Done with camera selection');
            // console.log('$no_ajax =  ' + $no_ajax);
            //
            $parsed = $.datepicker.parseDate("mm/dd/yy", $('#calendar').val());
            // console.log($parsed);
            // or we can use regex match
            // var result = $("#calendar").val().match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
            // console.log(result);
            $requestedFoto.selectedYear = $parsed.getFullYear();
            $requestedFoto.selectedMonth =  $parsed.getMonth() + 1 ;
            $requestedFoto.selectedDate = $parsed.getDate();
            // console.log($requestedFoto);
            getThumb();
        });
    });

    $("#calendar").datepicker({
        onSelect: showThumb
    });

    function showThumb(dateText, inst) {
        // console.log('on Select date');
        var dt = new Date(dateText);
        var date = $.datepicker.parseDate(inst.settings.dateFormat || $.datepicker._defaults.dateFormat, dateText, inst.settings);
        $requestedFoto.selectedCamera = $('#selectedScreen :selected').val();
        $requestedFoto.selectedYear = $.datepicker.formatDate("yy", date, inst.settings);
        $requestedFoto.selectedMonth = $.datepicker.formatDate("mm", date, inst.settings);
        $requestedFoto.selectedDate = $.datepicker.formatDate("dd", date, inst.settings);
        getThumb();
        // $no_ajax = false;
    }


    function getThumb() {
        // console.log('get Thumb called');
        var request = $.ajax({
            data: $requestedFoto,
            dataFilter: function(result, type) {
                // console.group('DataFilter');
                // console.log(result);
                // console.log(type);
                // console.groupEnd();
                if (type === 'JSON') {
                    var parsed_data = $.parseJSON(result);
                    // console.info('Parsed Data');
                    // console.log(parsed_data);
                    var rex = new RegExp($projectFolder + "(.*)", "gi");
                    var $src = [];
                    $.each(parsed_data.foto, function(i, v) {
                        var rPath = v.path.match(rex); // relative path from project root
                        // console.log(rPath);
                        $src[i] = $location + '/' + rPath + '/' + v.thumb;
                    }); // end of each
                    var $waqt = parsed_data.waqt;
                    $thumbList = JSON.stringify({foto: $src, waqt: $waqt});
                    return $thumbList;
                } // end of if
            } // end of DataFilter
        });

        request.done(function(resp) {
            // console.info('\n AJAX response');
            //$no_ajax = false;
            var resp_ = resp;
            // console.log(resp_);
            // console.info(resp.waqt);
            $('#timeSlot').empty();
            if(null !== resp_.waqt) {
                $.each(resp_.waqt, function(i,v) {
                    $('<div class="clickTime"><label>' + v + '</label><span>OK</span></div>')
                    .appendTo('#timeSlot');
                });
                $('#timeSlot div').eq(0).addClass('highlightedTime');
            }
                $thumbImg.add($mainImg).fadeOut('fast').promise().done(function() {
                   $thumbImg.prop('src', resp_.foto[0]);
                   $mainImg.prop('src', resp_.foto[0]);
                   $thumbImg.add($mainImg).fadeIn('fast');
                });
          });
         request.fail(function(jqXHR, textStatus) {
            //$no_ajax = true;
            if (jqXHR.statusText == "canceled") {
                alert("Please select a camera.");
            }
        });
    }

    $('#timeSlot').on('click', ' div.clickTime', function() {
        // console.warn('time slot clicked');
        var $parsedThumb = JSON.parse($thumbList);
        // console.log($pt);
        $(this).addClass('highlightedTime').siblings().removeClass('highlightedTime');
        var myIndex = $(this).prevAll().length;
        // console.log('index' + myIndex);
        var thumbName = $parsedThumb['foto'][myIndex]; // $pt.foto[myIndex];
        // console.log(thumbName)
        $thumbImg.add($mainImg).fadeOut('fast').promise().done(function() {
            $thumbImg.prop('src', thumbName);
            $mainImg.prop('src', thumbName);
            $thumbImg.add($mainImg).fadeIn('fast');
        });
    });

});
//# sourceURL=dynamicScript.js
</script>