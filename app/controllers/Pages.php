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
		$this->view("index", $data, $comments, $likes);
	}
}

?>
