<?php
class Projects extends Controller {

	public function __construct() {
		parent::__construct();
		Auth::handleLogin();
	}

	public function index() {
		// get all projects list of logged in user
		$this->view->project_list = $this->model->getAllProjects();
        //access with $this->project_list in below view file
		$this->view->render('projects');
	}

	public function edit_project($project_id)
	{
		$this->view->project = $this->model->getProject($project_id);
		$this->view->render('edit_project');
	}
	public function defaultview() {
		// echo "here you are".__METHOD__;

		$this->view->render('default');
	}

	public function splitscreen() {
		// echo "here you are".__METHOD__;
		$this->view->render('splitscreen');
	}

	public function fullscreen(){
		$this->view->render('fullscreen');
	}

	public function rightscreen() {
		$this->view->render('rightscreen', true);
	}
}