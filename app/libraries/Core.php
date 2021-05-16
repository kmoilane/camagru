<?php

	//Core App Class
	class Core
	{
		protected $currentController = "Pages";
		protected $currentMethod = "index";
		protected $params = [];

		public function __construct()
		{
			$url = $this->getUrl();

			// Look for the first value in controllers/, ucwords capitalizes the first letter to match file names
			if (file_exists("../app/controllers/" . ucwords($url[0]) . ".php"))
			{
				//Sets a new controller
				$this->currentController = ucwords($url[0]);
				unset($url[0]);
			}

			// Require the controller
			require_once "../app/controllers/" . $this->currentController . ".php";
			$this->currentController = new $this->currentController;

			// Check for the second part of the url
			if (isset($url[1]))
			{
				if (method_exists($this->currentController, $url[1]))
				{
					$this->currentMethod = $url[1];
					unset($url[1]);
				}
			}

			// Get parameters
			$this->params = $url ? array_values($url) : [];

			// Call a callback with array of params
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		}

		public function getUrl()
		{
			if (isset($_GET['url']))
			{
				// Removes '/' from the end of the url
				$url = rtrim($_GET['url'], '/');

				// Filter url string by only url accepted characters, letters and special characters
				$url = filter_var($url, FILTER_SANITIZE_URL);

				// Splits the string into an array
				$url = explode('/', $url);

				return $url;
			}
		}
	}

?>
