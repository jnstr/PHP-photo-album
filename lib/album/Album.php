<?php
class Album {
	/**
	 * @static
	 */
	public static function run() {
		require_once('setup.php');

		// setup the album config
		$config = new AlbumConfig();
		$config->setup();

		$auth = new AlbumAuth();
		$auth->auth();

		// download a single image
		$download = new AlbumDownload();
		$download->downloadImage();

		// build the album
		$build = new AlbumBuilder();
		$build->build();

		// view the album
		$viewer = new AlbumViewer();
		$viewer->view();
	}
}