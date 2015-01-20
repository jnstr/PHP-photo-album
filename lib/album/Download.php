<?php
namespace Jnstr\Album;


/**
 * Class Download
 * @package Jnstr\Album
 */
class Download {

	/**
	 * Download a single image (given by the get params)
	 */
	public function image($file) {
		// this doesn't seem a valid file name... ;-)
		if (strpos($file,'../') !== false || strpos($file,'./') !== false) Error::displayErrorPage(403);

		// the file path
		$file = ALBUM_PATH_ORIGINAL . '/' . $file;

		// force the browser to download the file
		if ((isset($file))&&(file_exists($file))) {
			header("Content-length: ".filesize($file));
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . $file . '"');
			readfile("$file");
		} else {
			echo "No file selected";
		}
		exit;
	}

}