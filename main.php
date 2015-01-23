<?php require_once ('constant.php'); require_once ('config.php'); ?>
<!doctype html>
<html>
<head>
	<title>Directree</title>
    <meta charset="utf-8">
    <!-- <base target="blank" href="<?=URL?>"> -->
    <link rel="canonical" href="<?=URL?>"/>
    <link rel="stylesheet" href="<?=CSS?>/reset.css" />
    <link rel="stylesheet" href="<?=CSS?>/style.css">
    <link rel="stylesheet" href="<?=CSS?>/defaultview.css">
    <!-- <link rel="stylesheet" href="<?=CSS?>/dark-hive/jquery-ui-1.10.3.custom.min.css" /> -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-darkness/jquery-ui.min.css" >
    <!-- jQuery custom -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <!-- <script src="<?=JS?>/jquery-ui-1.10.3.custom.js"></script> -->
    <script src="<?=JS?>/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="<?=JS?>/custom.js"></script>
</head>
<body>
<!-- Header -->
<?php
    static $loggedIn = false;
    $singleProject = true;
    // $_SESSION['projects'] = $_GET['projects'];
	// This is where the variables from client choices need to be set for application wide use
	// $project = "QGC1-2";
	// $scene = $_GET['scene_select'];
	// $date = "";
    //if project id gievn in URL and showing detail for one project
    //
    if (isset($_GET['id'])) {

        $singleProject = false;
        // $projectName = $this->project['project_name'];
        // $projectFolder = $this->project['project_folder'];
        // $projectURL = $this->project['project_url'];
        // $projectLogo = $this->project['project_logo'];
    }

    $logo = ($singleProject) ? IMG.DS.'default.jpg' :  IMG.DS.$projectLogo;
    $projectHeader = ($singleProject) ?  " == PROJECT NAME == " : $projectName ;

?>
<!-- Header -->
<header>
    <h2>Example</h2>
</header>
