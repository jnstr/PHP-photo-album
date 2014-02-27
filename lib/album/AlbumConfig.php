<?php
class AlbumConfig {

	public $path;
	public $imagePath;
	public $thumbPath;
	public $viewPath;
	public $includeFolder;
	public $configFile;
	
	/**
	 * Setup the album
	 */
	public function setup() {
		// get the request uri
		$request = $this->getRequest();
		// get the album config
		$this->getConfig($request);
		// set the vars
		$this->setVars($request);
	}

	/**
	 * Get the request uri (without the get-params)
	 *
	 * @return mixed
	 */
	private function getRequest() {
		$request = $_SERVER['REQUEST_URI'];

		// drop off the get params
		if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {
			$requestArr = explode('?', $request);
			$request = $requestArr[0];
		}

		// remove the index.php file
		$request = str_replace('index.php','',$request);

		return $request;
	}

	/**
	 * Get the config file (website_root/config/config.php)
	 *
	 * @param $requestUri
	 */
	private function getConfig($requestUri) {
		// set the config file
		$config = $_SERVER['DOCUMENT_ROOT'] . "$requestUri/config/config.php";
		require_once($config);
	}

	/**
	 * Set the vars
	 *
	 * @param $requestUri
	 */
	private function setVars($requestUri) {
		// set the paths
		define("ALBUM_PATH",str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . "$requestUri/album"));
		define("ALBUM_PATH_ORIGINAL", ALBUM_PATH . '/original');
		define("ALBUM_PATH_THUMBNAILS", ALBUM_PATH . '/thumbnails');

		// define the path for the view files
		define("VIEW_PATH", $_SERVER['DOCUMENT_ROOT'] . "$requestUri/view");

		// define the include folder
		define ("INCLUDE_FOLDER", $_SERVER['DOCUMENT_ROOT'] . "$requestUri/includes");
	}


}