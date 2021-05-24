<?php

class Pages extends Controller
{
	public function __construct() {
		$this->pageModel = $this->model('Page');
	}

	public function index()
	{
		$data = $this->pageModel->gallery();
		$comments = $this->pageModel->getComments();
		$likes = $this->pageModel->getLikes();
		$data[0]->total_images = $this->pageModel->getImageCount();
		$data[0]->page = isset($_GET["page"]) && is_numeric($_GET["page"]) ? $_GET["page"] : 1;
		$data[0]->max_results_on_page = 5;


		$this->view("index", $data, $comments, $likes);
	}
}

?>
