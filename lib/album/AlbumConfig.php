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
		// set the vars
		$this->setVars($request);
		// get the album config
		$this->getConfig($request);
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
	 * Get the config file from the album folder
	 *
	 * @param $requestUri
	 */
	private function getConfig($requestUri) {
		// set the config file
		$config = ALBUM_PATH . "/config.php";
		require_once($config);
	}

	/**
	 * Gets the album folder name from the query string
	 */
	private function defineAlbumFolderName() {
		if (!isset($_GET['album'])) Error::displayErrorPage(404);
		define('ALBUM_FOLDER',$_GET['album']);
	}

	/**
	 * Set the vars
	 *
	 * @param $requestUri
	 */
	private function setVars($requestUri) {
		// define the include folder
		define ("INCLUDE_FOLDER", $_SERVER['DOCUMENT_ROOT'] . "$requestUri/includes");

		// define the album folder name
		$this->defineAlbumFolderName();

		// define the path for the view files
		define("VIEW_PATH", $_SERVER['DOCUMENT_ROOT'] . "$requestUri/albums/" . ALBUM_FOLDER . "/view");

		// the path for the album
		define("ALBUM_PATH",str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . "$requestUri/albums/" . ALBUM_FOLDER . "/"));
		// does the album folder exist?
		if (!is_dir(ALBUM_PATH)) Error::displayErrorPage(404);

		// the path where the images are stored
		define("ALBUM_PATH_ORIGINAL", ALBUM_PATH . '/original');
		define("ALBUM_PATH_THUMBNAILS", ALBUM_PATH . '/thumbnails');
	}


}