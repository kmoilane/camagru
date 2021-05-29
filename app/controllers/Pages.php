<?php

class Pages extends Controller
{
	public function __construct() {
		$this->pageModel = $this->model('Page');
	}

	public function index()
	{
		$data = [];
		$total_images = $this->pageModel->getImageCount();
		$rpp = 5;
		$page = 1;
		$final_page = ceil(($total_images / $rpp));

		if (isset($_GET["page"]) && is_numeric($_GET["page"]) && $total_images > 0)
		{
			$page = htmlentities($_GET["page"]);

			if ($page > 1 && $page <= $final_page)
			{
				$data = $this->pageModel->gallery(($rpp * ($page - 1)), 5);
				$data[0]->total_images = $total_images;
				$data[0]->page = $page;
				$data[0]->rpp = 5;
				$data[0]->final_page = $final_page;

				$this->view("index", $data);
			}
			else
			{
				$data = $this->pageModel->gallery();
				$data[0]->total_images = $total_images;
				$data[0]->page = $page;
				$data[0]->rpp = 5;
				$data[0]->final_page = $final_page;

				$this->view("index", $data);
			}
		}
		else if ($total_images > 0)
		{
			$data = $this->pageModel->gallery();
			$data[0]->total_images = $total_images;
			$data[0]->page = $page;
			$data[0]->rpp = 5;
			$data[0]->final_page = $final_page;

			$this->view("index", $data);
		}
		else
			$this->view("index");
	}
}

?>
