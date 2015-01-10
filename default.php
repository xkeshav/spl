<?php
    $obj_prj = new ProjectIterator();
    $projectFolderDir = ARCHIVE.DS.'QGC3-7';
    // $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7','s3', '201408');
    // get ALL screen /camera list of selected project and show on left panel dropdown
    $screenList = $obj_prj->getProjectScreenList($projectFolderDir);
    // d($screenList);
    // $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7','s3', '201408');
    // $FolderThumbList = $obj_prj->getScreenThumb();
    // d($FolderThumbList);
    // preg_grep('/$thumb_partial_name/d_tn.jpg/',$FolderThumbList);


?>
<div class="wrapper">
    <section id="left" >
        <div id="mainThumb">
        <img src="<?php echo URL.'/img/default.jpg'?>"width="100%" title="Current Thumb" />
        <!-- <div id="slider" width="300px"></div> -->
        </div>
        <div id="screen">
            <select class="dropdown" id="selectedScreen">
                <option value="" selected disabled style="color:#000"  >Select Camera</option>
            <?php foreach ($screenList as $sc=>$sv) {
                echo "<option value='$sc' title='$sc'>Camera $sc</option>";
                 } // end o foreach ?>
<!--                 <option value="s2" title="s2">Camera s2</option>
                <option value="s3" title="s3">Camera s3</option>
                <option value="s4" title="s4">Camera s4</option>
                <option value="s5" title="s5">Camera s5</option> -->
            </select>
        </div>
        <div id="calendar"></div>
        <div id="timeSlot" style="margin-bottom:10px;">
        <!--
            <div class="clickTime"><label>01:10:10</label><span>OK</span></div>
        -->
        </div>
    </section>

   <section id="right" >
 <?php
    // var_dump($_POST);
    // $obj_prj = new ProjectIterator();
    // $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7', 's3', '201408');
    // $screenThumbList = $obj_prj->getScreenFolder();
    // $allThumb = $obj_prj->getScreenThumb();
    // $recentThumb = $obj_prj->getRecentThumb();
    // d($screenThumbList, $allThumb, $recentThumb);
    // $tk = array_keys($allThumb);
    // // d($tk);
    // $timeslot = $obj_prj->getDayTimeList($tk);

    // d($timeslot);

    // foreach ($screenThumbList['s3'] as $st) {
    //     $month_a[] = substr($st->getFileName(),-2);
    // }
    // d($month_a);

?>
    <figure>
        <!-- <figurecaption>S3 DATE 14-10-2014 01:10:10</figurecaption> -->
        <img src="<?php echo URL.'/img/default.jpg'?>" />
    </figure>
    </section>
</div>

<script>
    $(function() {
    // $( "#slider" ).slider();
    var $projectRoot = '<?=URL.DS?>',
        $projectFolder = '<?=PROJECT_FOLDER?>',
        $requestedFoto = {},
        $thumbList = {};
        $availMonth = {},
        $selectedScreen = false;
        var $ajax = false;
    //default setting for jquery ajax call
    $.ajaxSetup({
        url: $projectRoot + '/projects/rightscreen',
        global: false,
        type: 'POST',
        dataType: 'JSON',
        context: document.body,
        timeout: 30000, // timeout after 30 seconds
        beforeSend: function() {
            console.log('AJAX VALUE' + $ajax);
            // console.dir($requestedFoto);
            $cameraEmpty = $.isEmptyObject($requestedFoto.selectedCamera);
            // console.log('Is camera empty:' + $cameraEmpty);
            // console.dir(xhr);
            return !$cameraEmpty;
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
        console.info('On Change Fired');
        $selectedScreen = $(this).val();
        $requestedFoto.selectedCamera = $selectedScreen;
        $.get($projectRoot + 'projects/rightscreen', { screen: $selectedScreen })
        .done(function(resp) {
            // store all availble months of selected screen scanning from directory folder
            // console.log(resp);
            $availMonth = resp;
            // console.info('Done with camera selection');
            // console.log($requestedFoto);
            console.log('AJAX after camera change' + $ajax);
            if($ajax) {
                getThumb();
            }
            // $('#calendar').datepicker('setDate', null);
            // $('#calendar').prop('disabled',false);
            // $('#calendar').datepicker('show');
        });
    });

    $("#calendar").datepicker({
        onSelect: showThumb
    });

    function showThumb(dateText, inst) {
        console.log('onSelect fired');
        var dt = new Date(dateText);
        var date = $.datepicker.parseDate(inst.settings.dateFormat || $.datepicker._defaults.dateFormat, dateText, inst.settings);
        $requestedFoto.selectedCamera = $('#selectedScreen :selected').val();
        $requestedFoto.selectedYear = $.datepicker.formatDate("yy", date, inst.settings);
        $requestedFoto.selectedMonth = $.datepicker.formatDate("mm", date, inst.settings);
        $requestedFoto.selectedDate = $.datepicker.formatDate("dd", date, inst.settings);
        getThumb();
        $ajax = true;
    }


    function getThumb() {
        var request = $.ajax({
            data: $requestedFoto,
            dataFilter: function(data, type) {
                // console.group('DataFilter');
                // console.log(data);
                // console.log(type);
                // console.groupEnd();
                if (type === 'JSON') {
                    var parsed_data = JSON.parse(data);
                    console.info('Parsed Data');
                    console.log(parsed_data);
                    if (true === parsed_data[0]) {
                        var $src = [];
                        $.each(parsed_data.foto, function(i, v) {
                            console.log(v.path);
                            // console.log(thumbPath);
                            // var rp = v.path.substring(v.path.lastIndexOf('<?=PROJECT_FOLDER?>'));
                            var rex = /$projectFolder(.*)/gi;
                            // console.log(rex);
                            var rPath = v.path.match(rex); // relative path from project root
                            console.log(rPath);
                            $src[i] = $projectRoot + rPath + '/' + v.thumb;
                            // $('<div class="clickTime"><label>' + v + '</label><span>OK</span></div>')
                            // .appendTo('#timeSlot');
                        }); // end of each
                        // console.log($src);
                        $thumbList = JSON.stringify({
                            'foto': $src,
                            'waqt': parsed_data.waqt
                        });
                        console.log($thumbList);
                        return $thumbList;
                    } // end of parsed data if
                    else {
                        console.log('no foto');
                        var p = parsed_data.foto.path;
                        var rex = /$projectFolder(.*)/gi;
                            // console.log(rex);
                        var rPath = p.match(rex); // relative path from project root
                        console.log(rPath);
                    }
                } // end of if
            } // end of DataFilter
        });

        request.done(function(resp) {
            console.info('AJAX value trulyfied');
            $ajax = true;
            console.log($ajax);
            console.log(resp);
            // console.info(resp.waqt);
            $('#timeSlot').empty();
            // $('#mainThumb img').src('')
            // if(true === resp[0]) {
            //     $thumbList = resp;
            //     $.each(resp.waqt, function(i,v) {
            //         // console.log(v);
            //         $('<div class="clickTime"><label>' + v + '</label><span>OK</span></div>')
            //         .appendTo('#timeSlot');
            //     });
            //     var thumbName = resp.foto[0].thumb,
            //         thumbPath = resp.foto[0].path;
            //     // console.log(thumbName,thumbPath);

            //     var rp = thumbPath.substring(thumbPath.indexOf('<?=PROJECT_FOLDER?>'));
            //     // console.info(rp);
            //     var $src = $projectRoot + rp + '/' + thumbName;
            //     // console.info($src);
            //     $('#mainThumb img').prop('src', $src);
            // } else {
            //     var thumbName = resp.foto.thumb,
            //     thumbPath = resp.foto.path;
            //     // var n = thumbPath.match('(.*)/eonfx.*', $m);
            //     var rp = thumbPath.substring(thumbPath.indexOf('<?=PROJECT_FOLDER?>'));
            //     // console.log(rp);
            //     var $src = $projectRoot + rp + '/' + thumbName;
            //     // var $src = window.location.protocol +  window.location.hostname + '/' + rp + '/' +thumbName;
            //     // console.log($src);
            //     //"/opt/lampp/htdocs/eonfx/data/archive_links/QGC3-7/s3/201408/thumbnails"
            //     //"http://192.168.0.228/eonfx/data/archive_links/QGC3-7/s3/201408/thumbnails"
            //     $('#mainThumb img').prop('src', $src);
            // }


        });
        request.fail(function(jqXHR, textStatus) {
            // console.group('Error');
            // console.dir(jqXHR);
            if (jqXHR.statusText == "canceled") {
                alert("Please select camera first");
            }
        });
    }



    $('#timeSlot').on('click', 'div.clickTime', function() {
        // console.warn('time slot clicked');
        // console.log($thumbList);
        $('div.clickTime').removeClass('highlightedTime');
        $(this).addClass('highlightedTime');
        var myIndex = $(this).prevAll().length;
        // console.log(myIndex);
        var thumbName = $thumbList.foto[myIndex].thumb,
            thumbPath = $thumbList.foto[myIndex].path;
        // console.log(thumbName,thumbPath);
        var rp = thumbPath.substring(thumbPath.indexOf('<?=PROJECT_FOLDER?>'));
        // console.info(rp);
        var $src = projectRoot + rp + '/' + thumbName;
        // console.info($src);
        $('#mainThumb img').prop('src', $src);
    });

});
//# sourceURL=dynamicScript.js
</script>