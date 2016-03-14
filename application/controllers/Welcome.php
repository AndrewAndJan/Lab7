<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->model('Timetable');

        $this->data["title"] = "CST Timetable";
        $this->data['pagebody'] = 'welcome';
        
        $this->data["daysofweek"] = $this->Timetable->getDays();
        $this->data["courses"] = $this->Timetable->getCourses();
        $this->data["periods"] = $this->Timetable->getPeriods();
        
        $this->render();
	}
}
