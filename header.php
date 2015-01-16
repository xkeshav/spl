<!doctype html>
<html>
<?php require_once 'constant.php'; ?>
<head>
	<title>Directree</title>
    <meta charset="utf-8">
    <!-- <base target="blank" href="<?=URL?>"> -->
    <link rel="canonical" href="<?=URL?>"/>
    <link rel="stylesheet" href="<?=CSS?>/reset.css" />
<!--     <link rel="stylesheet" href="<?=CSS?>/home.css"> -->
    <link rel="stylesheet" href="<?=CSS?>/style.css">
    <link rel="stylesheet" href="<?=CSS?>/defaultview.css">
    <!-- jQuery custom -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <script src="<?=JS?>/jquery-1.11.2.min.js"></script>
    <script src="<?=JS?>/jquery-ui-1.10.3.custom.js"></script>
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
    if(isset($_GET['id'])) {
        $singleProject = false;
        // $projectName = $this->project['project_name'];
        // $projectFolder = $this->project['project_folder'];
        // $projectURL = $this->project['project_url'];
        // $projectLogo = $this->project['project_logo'];
    }

    $logo = ($singleProject) ? IMG.'default.png' :  IMG.$projectLogo;
    $projectHeader = ($singleProject) ?  " == PROJECT NAME == " : $projectName ;

?>
<!-- Header -->
<header>
	<div class="headerbg">
		<div class="headerspacer">&nbsp;</div>
		<div class="headerinfo">
			<div class="headerlogo">
		    <?php if (!$singleProject) : ?>
                <a href="<?=$projectURL?>">
            <?php endif; ?>
			     <img src="<?=$logo?>">
			</div>
			<div class="headerproject">
				<h1 valign="top" ><?=$projectHeader?></h1>
				<span><input type="text" id="date_input" readonly title="Today" /></span>
			</div>
		</div>
	</div>
<!-- Navbar Icons -->
	<div class="navbar">
		<?php if(!$loggedIn) { ?>
            <!-- <li > -->
            <nav class="navbar_left_box" >
                <ul class="ui-widget ui-helper-clearfix">
    				<li class="ui-state-default ui-corner-all" title="User Profile">
    					<a href="<?=URL?>users"><span class="ui-icon ui-icon-person"></span></a>
    				</li>
    				<li class="ui-state-default ui-corner-all" title="Projects">
    					<a href="<?=URL?>projects"><span class="ui-icon ui-icon-folder-collapsed"></span></a>
    				</li>
    				<li class="ui-state-default ui-corner-all" title="Project Settings">
    					<a href="<?=URL?>settings"><span class="ui-icon ui-icon-gear"></span></a>
    				</li>
                </ul>
    		</nav>
            <nav class="navbar_middle_box">
    			<ul class="ui-widget ui-helper-clearfix">
    				<li class="ui-state-default ui-corner-all" title="Default View">
    					<a href="<?=URL?>projects/defaultview"><span class="ui-icon ui-icon-defaultview"></span></a>
    				</li>
    				<li class="ui-state-default ui-corner-all" title="Split Screen View">
    					<a href="<?=URL?>projects/splitscreen"><span class="ui-icon ui-icon-bookmark"></span></a>
    				</li>
    				<li class="ui-state-default ui-corner-all" title="Full Screen View">
    					<a href="<?=URL?>projects/fullscreen"><span class="ui-icon ui-icon-image"></span></a>
    				</li>
    				<li class="ui-state-default ui-corner-all" title="Calendar View">
    					<a href="<?=URL?>calendar"><span class="ui-icon ui-icon-calculator"></span></a>
    				</li>
    				<li class="ui-state-default ui-corner-all" title="Time-laspe Slideshow">
    					<a href="<?=URL?>slideshow"><span class="ui-icon ui-icon-video"></span></a>
    				</li>
    			</ul>
            </nav>
            <nav class="navbar_right_box">
                <ul class="ui-widget ui-helper-clearfix">
    				<li class="ui-state-default ui-corner-all" title="Project Information">
    					<a href="#" id="dialog-link"><span class="ui-icon ui-icon-info"></span></a>
    				</li>
			     </ul>
            </nav>
        <?php } ?>
    </div>
</header>
