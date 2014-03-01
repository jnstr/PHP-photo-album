<?php
class AlbumDownload {

	/**
	 * Download a single image (given by the get params)
	 */
	public function downloadImage() {
		// only if we want to download a file
		if (!isset($_GET['file'])) return;

		// this doesn't seem a valid file name... ;-)
		if (strpos($_GET['file'],'../') !== false || strpos($_GET['file'],'./') !== false) Error::displayErrorPage(403);

		// the file path
		$file = ALBUM_PATH_ORIGINAL . '/' . $_GET['file'];

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