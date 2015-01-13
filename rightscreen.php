<?php
/**
 * @access private
 * @author X <nomail@boun.cr>
 * @copyright Dotsquares technologies
 * @example  this file is called from defaultview.php in ajax functions and it will return the data this function use projectItertor class
 * @date( Jan 12,2015)
 * @copyright This code is regulated on dotsquares technlogies, any changes must be inform to the author
 * @version 1.12
 **/

error_reporting(E_ALL& ~(E_WARNING|E_NOTICE));

$obj_prj = new ProjectIterator();
if(!empty($_POST)) {
    // var_dump($_POST);
    $info ='';
    extract($_POST);
    $selectedDateYM = $selectedYear.$selectedMonth;
    $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7', $selectedCamera, $selectedDateYM);
    // $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7','s3', '201408');
    // $screenList = $obj_prj->getScreen();
    $screenFolderList = $obj_prj->getScreenFolder();
    // d($screenFolderList);
    // first check whether selected date folder exist or not
    if(!empty($screenFolderList) && array_key_exists($selectedDateYM, $screenFolderList[$selectedCamera])) {
        $FolderThumbList = $obj_prj->getScreenThumb();
        // !d($FolderThumbList);
        if(!empty($FolderThumbList)) {
            $all_thumb = array_keys($FolderThumbList);
            // d($all_thumb);
            preg_match('#\d+#', $selectedCamera , $m);
            // Change sx into s0x
            $selectedFolder= str_pad($m[0], 2, '0', STR_PAD_LEFT);
            $thumb_partial_name = ['s', $selectedFolder, $selectedDateYM, $selectedDate];
            $thumb_partial_string = implode('',$thumb_partial_name);
            $thumb_list = preg_grep("#$thumb_partial_string#i", $all_thumb);
            // d($thumb_list); // array keys are diffremt , not intialized from 0, 1
            if(!empty($thumb_list)) {
                $thumb_list_indexed = array_values($thumb_list);
                // !d($thumb_list_indexed);
                // $s_ = array_map('getTime', $tk);
                // $thumb_list_indexed => [s0320140802120308_tn.jpg","s0320140802165133_tn.jpg"]
                $datetime_slot = $obj_prj->getDayTimeList($thumb_list_indexed);
                // $datetime_slot =>
                // '$selectedDate (02)' => [
                //         "12:03:08"
                //         "16:51:33"
                //     ]
                // !d($selectedDate,$datetime_slot);
                if( array_key_exists($selectedDate, $datetime_slot) ) {
                        $thumb_time = $datetime_slot[$selectedDate];
                        // d($thumb_time);
                }
                $return_array = array_intersect_key($FolderThumbList, array_flip($thumb_list));
                foreach($return_array as $rk=>$rv ) {
                    // !d(($rk));
                    // $final_thumb_data[$i]['path'] = $rv->getPath();
                    $final_thumb_data[] = ['thumb'=> $rk, 'path'=>$rv->getPath()];
                 }
                // $final_thumb_data_ = empty($final_thumb_data) ? (object) null : $final_thumb_data;
                // !d($final_thumb_data_);
                // $ft = json_encode($final_thumb_data_, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES );
                // !d($ft);

                $output = [true, 'foto'=>$final_thumb_data, 'waqt'=>$thumb_time ];
                /**
                 * !d(json_encode($output, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES));
                {
                    "0": true,
                    "foto": {
                        "0": {
                            "thumb": "s0320140726120618_tn.jpg",
                            "path": "/opt/lampp/htdocs/eonfx/data/archive_links/QGC3-7/s3/201407/thumbnails"
                        },
                        "1": {
                            "thumb": "s0320140726164820_tn.jpg",
                            "path": "/opt/lampp/htdocs/eonfx/data/archive_links/QGC3-7/s3/201407/thumbnails"
                        }
                    },
                    "waqt": {
                            "0": "12:06:18",
                            "1": "16:48:20"
                    }
                }
                *
                * */

            } else {
                $msg = "Given date $selectedDate have no foto";
                $recentThumb = $obj_prj->getRecentThumb();
                // !d($recentThumb);
                $recentThumb_[] = ['thumb'=> $recentThumb['thumb'], 'path'=>$recentThumb['path'] ];
                // $recentThumb_ = ['thumb'=> $recentThumb.thumb, 'path'=>$recentThumb.path]
                $output = [false, 'foto'=> $recentThumb_, 'waqt'=>NULL, $info => $msg ];
                /**
                {
                    "0": false,
                    "foto": [
                        "thumb": "s0320140731121908_tn.jpg",
                        "path": "/opt/lampp/htdocs/eonfx/data/archive_links/QGC3-7/s3/201407/thumbnails"
                    ],
                    "waqt": null
                }
                *
                **/
            }
        }
        //else {
        //  $msg ='folderthumb list empty';
        //  $latestThumb = $obj_prj->getRecentThumb();
        //  $output = [false, 'info'=>$msg, $latestThumb];
        // }
    } else {
        $msg = "Given month $selectedMonth have no foto";
        $recentThumb = $obj_prj->getRecentThumb();
        //!d($recentThumb);
        $recentThumb_[] = ['thumb'=> $recentThumb['thumb'], 'path'=>$recentThumb['path'] ];
        $output = [false, 'foto'=> $recentThumb_, 'waqt'=>NULL , $info => $msg ];
    }
    $return = json_encode($output, JSON_UNESCAPED_SLASHES);
    // !d($return);
    echo $return;
    // preg_grep('/$thumb_partial_name/d_tn.jpg/',$tk);
    // preg_grep('/$thumb_partial_name/d_tn.jpg/',$FolderThumbList);
    // echo $thumb = "s".$selectedCamera.$selectedDateYM.$selectedDate."_tn.jpg";
}

// we retriev month name on select of screen , which canb further use while choosing date from calendar
if ( !empty($_GET['screen']) ) {
    $selectedScreen = $_GET['screen'];
    $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7', $selectedScreen);
    $screenFolderList = $obj_prj->getScreenFolder();
    // !d($screenFolderList);
    $month_list = [];
    foreach ($screenFolderList[$selectedScreen] as $st) {
       array_push($month_list, substr($st->getFileName(),-2));
    }
    // d(json_encode($month_list));
    echo json_encode($month_list);
}
?>