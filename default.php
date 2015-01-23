<?php namespace DTREE\parixan;

require_once __DIR__.'/directree.class.php';
require __DIR__.'/kint/Kint.class.php';
use DTREE as DT;
$project_folder = $_SERVER['DOCUMENT_ROOT'].'cashbox';
d($project_folder);
DT\Directree::$projectDir = $project_folder;
$dt_ = new DT\Directree();
d($dt_);
// $screenList = $dt_->getScreenList();
// d($screenList);
// $screenList = DT\Directree::gcl();
// d($screenList);
// $obj_prj->getThumb(ARCHIVE.DS.'QGC3-7','s3', '201408');
// get ALL screen /camera list of selected project and show on left panel dropdown
//$screenList = $obj_prj->getProjectScreenList($projectFolderDir);
// d($screenList);
?>
