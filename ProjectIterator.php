<?php

// This class will find the latest thumb of each folder
// error_reporting(E_ALL ^ E_NOTICE);
// @author Keshav Mohta
// @date Dec 19, 2014
// $loc = "/opt/lampp/archive/data";
// $obj_latest = new latest();
// $thumbList = $obj_latest->latestThumb($loc);
class ProjectIterator extends Controller
{
    public static $thumb_folder = 'thumbnails';
    private $basepath;
    private $flags;
    protected $iterator;
    protected $screens;
    protected $screenFolder;
    protected $thumbList;
    protected $latestThumbList = [];
     // all screen latest thumb list
    protected $recentThumb = [];
    protected $dayWithTime = [];
     // [thumb name , thumb location]

    public function __construct() {
        // var_dump(__FILE__);
        // var_dump($base);
        $this->iterator = new DirectoryIterator(dirname(__FILE__));
        // echo $this->iterator->getPath();
        $this->basepath = $this->iterator->getPath();
        // self::$thumb_folder = 'thumbnails';
        $this->flags = FilesystemIterator::SKIP_DOTS | FilesystemIterator::NEW_CURRENT_AND_KEY | FilesystemIterator::KEY_AS_FILENAME;
    }

    /** get camera list of a project  */
    public function getProjectScreenList($projectDir){
        $dir = (func_num_args()) ? $projectDir : $this->basepath;
        $RealPath = realpath($dir);
        // d($RealPath);
        $Directory = new RecursiveDirectoryIterator($RealPath, $this->flags);
        // echo "<pre>"; print_r($Directory); echo "</pre>";
        // self::pre($Directory);
        // d($Directory);
        // +d($Directory->__toString());
        // $Dir_ = iterator_to_array($Directory);
        // ksort($Dir_); // NOTE: Most Important step
        // get all folder (screen) name of project
        $this->screens = $this->getAllFolder($Directory);
        // d($this->screens);
        return $this->screens;
    }
    /*
     Here we first find all parent directory (project) name of given dir
     and then check into each directory and find latest thumb of respective directory
     hwre we call `findLatest()` method to find thumbnail
     @param string $base_dir Physical location of projecr directory
     @param string $camera camera name of given folder
     @return associative array contains most recent thumbnail name and it's path  under key of folder name

    when $camera  is not FALSE then

    @return $this->screenFolder multidimensional associative array with `camera` and `thumbnails` key
        eg for $camera = s5 it will return
        $this->screenFolder array (2)

            's5' => array (4)

                '201409' => object SplFileInfo (0)

                '201410' => object SplFileInfo (0)

                '201411' => object SplFileInfo (0)

                '201412' => object SplFileInfo (0)

            'thumbnails' => array (8)

                's0520141201111928_tn.jpg' => object SplFileInfo (0)

                's0520141202110748_tn.jpg' => object SplFileInfo (0)

                's0520141203111703_tn.jpg' => object SplFileInfo (0)

                's0520141204110515_tn.jpg' => object SplFileInfo (0)

                's0520141205111515_tn.jpg' => object SplFileInfo (0)

                's0520141206110835_tn.jpg' => object SplFileInfo (0)

                's0520141206164753_tn.jpg' => object SplFileInfo (0)

                's0520141208110525_tn.jpg' => object SplFileInfo (0)
    */

    public function getThumb($givenDir = false, $givenCamera = false, $givenDate = false) {
        // $args = func_get_args();
        // d($args);
        // $dir = (func_num_args()) ? $givenDir : $this->basepath;
        // $RealPath = realpath($dir);
        // // d($RealPath);
        // $Directory = new RecursiveDirectoryIterator($RealPath, $this->flags);
        // // echo "<pre>"; print_r($Directory); echo "</pre>";
        // // self::pre($Directory);
        // // d($Directory);
        // // +d($Directory->__toString());
        // // $Dir_ = iterator_to_array($Directory);
        // // ksort($Dir_); // NOTE: Most Important step
        // // get all folder (screen) name of project
        // $this->screens = $this->getAllFolder($Directory);
        $this->getProjectScreenList($givenDir);
        if (!empty($givenCamera)) {
            // d($this->screens);
            // echo "<br/>Inside if";
            $cameraExist = array_key_exists($givenCamera, $this->screens);
            // d($cameraExist);
            if ($cameraExist) {
                // d($this->screenFolder);
                //calling this function will save all folder name in a  folder $this->screenFolder
                // print("<br/>now we have 2 arguments");
                $this->findLatest($this->screens[$givenCamera], $cameraExist);
                // d($this->screenFolder);
                if ($givenDate) {
                    // d($this->screenFolder);
                    // Now  we will find whether the given date folder exist on $given screen folder
                    $dateExist = array_key_exists($givenDate, $this->screenFolder[$givenCamera]);
                    // d($dateExist);
                    if ($dateExist) {
                        // d($this->screenFolder);
                        // print("<br/>Okay now we have 3 argument");
                        // d($this->screenFolder[$givenCamera][$givenDate]);
                        $this->findLatest($this->screenFolder[$givenCamera][$givenDate], $cameraExist, $dateExist);
                    }
                }
            }
            //return $this->screenFolder;
        } else {
            // echo "<br/>inside else";
            foreach ($this->screens as $kDir => $vDir) {
                // d($kDir,$vDir);
                // var_dump($vDir->current()->isDir()); // FATAL ERROR
                if ($vDir->isDir()) {
                    $this->findLatest($vDir);
                    $this->latestThumbList[$kDir] = $this->recentThumb;
                }
            }
            // d($this->latestThumbList);
            //return $this->latestThumbList;
        }
    }

    /*
        This function call recursively to get latest directoty each time till we get thumbnails folder
        and when we get thumbnails folder we will find the latest thumb of that folder and it's path
        @param object(SplFileInfo) $dir contains the directory name which we are scanning
        @param string $screen  camera name ( folder name )
        @return array [thumbnail name, thumbnail path]


    */
    private function findLatest($dir, $screen = false, $samay = false) {
        $farg = func_get_args();
        // d($farg);
        // d($dir);
        $currentDirName = $dir->getFileName();
        $currentDirPath = $dir->getRealPath();
        $Directory = new RecursiveDirectoryIterator($currentDirPath, $this->flags);
        // d($currentDirName,$currentDirPath,$Directory);
        // d($Dir_);
        // echo __LINE__."<BR/>BEFORE IF";
        // d($this->screenFolder);
        if ($screen) {
            // echo "<br/>Inside IF : the required screen:$currentDirName";
            $this->screenFolder[$currentDirName] = $this->getAllFolder($Directory);
            // d($this->screenFolder);
            if ($samay) {
                // echo "<br/>inside samaya";
                $thumbDir = $this->screenFolder[$currentDirName][self::$thumb_folder];
                $this->thumbList = $this->getAllThumb($thumbDir);
                //d($this->thumbList);
                // you can either comment this line
                $this->screenFolder[$currentDirName] = $this->thumbList;
            }
            // d($this->screenFolder);
        }

        // echo "<br/>outside of if";
        // d($this->screenFolder);
        // array all thumbnails
        // if($currentDirName == self::$thumb_folder ) {
        //     $this->screenFolder[$currentDirName] = $this->getAllThumb($Directory);
        // }
        // echo __LINE__."<BR/>NEXT TO IF";
        /*
        we can not sort on $Directory as this is RecursiveDirectoryIterator Object
        so first we changed object into array and the resultant default array is namewise ASC odrer so that latest created folder comes on last entry of array this is useful in this project because folder are genarted dynamically in below format
            <foldername><num><YYYY><MM><DD><HH><MM><SS>_thumb.jpg
        */
        $Dir_ = iterator_to_array($Directory);
        ksort($Dir_);
        // check whether we reached on final folder which have "thumbnails" folder inside
        //IF we reach on the desired folder than we will iterate one more time inside thumbnail folder
        $thumbFolderExist = array_key_exists(self::$thumb_folder, $Dir_);
        // d($thumbFolderExist);
        if ($thumbFolderExist) {
            // echo "Towards the thumbnails";
            $thumb = $this->getAllFolder($Directory);
            // d($thumb);
            return $this->findLatest($thumb[self::$thumb_folder]);
        }
        // ELSE get the last entry of sorted array which will be recent folder
        // d($Dir_);
        $dir_latest = array_pop($Dir_);
        // echo __LINE__;
        // d($dir_latest);
        /* check whether it is file or Directory */

        // var_dump("Parent Dierctory:".$currentDirName);
        // self::pre($currentDirName);
        // echo __LINE__;
        // now we recahed inside the thumb folder
        if ($currentDirName === self::$thumb_folder) {
            // echo "<br/>YES Thumbnails";
            // d(func_get_args());
            // $this->screenFolder[$currentDirName] = $this->getAlThumb($Directory);
            // d($this->screenFolder);
            // d($dir_latest->getPath());
            // d($dir_latest->getPathName());
            // d($dir_latest);
            $t_name = $dir_latest->getBaseName();
            // $t_path = $dir_latest->getRealPath();
            $t_path = $dir_latest->getPath(); // changed Jan 07 for similarity concern while output
            // !d($t_name,$t_path);
            $isFile = $dir_latest->isFile();
            $isReadable = $dir_latest->isReadable();
            // d($isFile , $isReadable);
            if ($isFile && $isReadable) {
                //save into protected variable
                $this->recentThumb = ['thumb'=>$t_name, 'path'=>$t_path];
                //return [$t_name,$t_path];
            }
        } else {
            // echo "<br/>inside final else";
            return $this->findLatest($dir_latest);
        }
    }

    /*Get all folder name of a directory
    @param object RecursiveDirectoryIterator $mainDir
    @return array of object SplFileInfo in namewsie ASC order
    */

    private function getAllFolder($currentDir) {
        // d($mainDir);
        $subFolder = [];
        foreach ($currentDir as $sub) {
            if ($currentDir->current()->isDir()) { // << only if  isDir()
                $folderName = $currentDir->current()->getBaseName();
                $subFolder[$folderName] = $currentDir->current();
            }
        }
        // d($subFolder);
        // $Dir_ = iterator_to_array($subFolder);
        ksort($subFolder);
        return $subFolder;
    }

    /* Get all thumb images inside thumbnail folder
    @param object RecursiveDirectoryIterator $thumbDir
    */
    private function hasThumbnailFolder($t_dir) {
        // d($t_dir['thumbnails']);
        if ($t_dir['thumbnails']->current()->getBaseName() === 'thumbnails') {
            d($t_dir->current());
            return $t_dir->current();
            //$this-> getAllThumb($t_dir->current());
        }
    }

    private function getAllThumb($thumbDir) {
        // d($thumbDir);
        $thumbDirIterator = new DirectoryIterator($thumbDir);
         // Directory Iterator
        // d($thumbDir_);
        $thumbnails = [];
        foreach ($thumbDirIterator as $thumb) {
            if ($thumbDirIterator->current()->isFile()) {
                 // << only if  isFile()
                $thumbName = $thumbDirIterator->current()->getBaseName();
                $thumbnails[$thumbName] = $thumbDirIterator->current();
            }
        }

        // d($thumbnails);
        ksort($thumbnails);

        // d($thumbnails);
        return $thumbnails;
    }

    /*
        $is = s0320140801121500_tn.jpg";
        @return  ["01"=> "12:15:00", "02"=>"12:10:10", ...];
     */

    public function getDayTime($is_a) {
        // d($is_a);
        $ts = substr($is_a, 9, -7); // get 01121500
        $as = str_split($ts,2); //
        $day = array_shift($as); // 01
        $waqt = implode(':', $as);
        // d($f,$waqt);
        if(!isset($this->dayWithTime[$day])) {
                $this->dayWithTime[$day] = [];
        }
        $this->dayWithTime[$day][] = $waqt;
    }
    // $ta ["01"=> "12:15:00"];
    public function getTimeSlots($ts) {
        // $ta_ = array_map($this->getTime, $tk);
        // d($ts);
        $ta_ = array_walk($ts, [$this,'getDayTime']);
        d($ts);
        d($this->dayWithTime);
        d($ta_);
        // $timeslot = [];
        // foreach ($ta_ as $item) {
        //     $day = key($item);
        //     $waqt = current($item);
        //     if(!isset($timeslot[$day])) {
        //         $timeslot[$day] = array();
        //     }
        //     $timeslot[$day][] = $waqt;
        // }
        // return $timeslot;
    }


    // return recentThumb array with thumb name and thumb location
    public function getRecentThumb() {
        return $this->recentThumb;
    }

    // return all screens latest thumbnail List
    public function getLatestThumbList() {
        return $this->latestThumbList;
    }

    public function getScreen() {
        return $this->screens;
    }

    // return screen folder name in associative array and if date is given then it will comes as second array
    public function getScreenFolder() {
        return $this->screenFolder;
    }

    // get all screen thumb of a specific date and screen
    public function getScreenThumb() {
        return $this->thumbList;
    }
    //@param  array $input
    //@return array woth key name is day and value is time in hh:mm:ss format
    public function getDayTimeList($input) {
        array_walk($input, [$this, 'getDayTime'] );
        return $this->dayWithTime;
    }
}
?>
