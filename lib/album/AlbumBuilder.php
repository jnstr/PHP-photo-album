<?php
class AlbumBuilder {

	/**
	 * Rebuild the album:
	 * a. remove all thumbnails and re-create tham
	 * b. re-generate the viewscript
	 */
	public function build() {
		// only if the index-view does not exist, of if the rebuild get-param has been set
		if (!file_exists(VIEW_PATH . '/index.html') || (isset($_GET['rebuild']) && $_GET['rebuild'] == '1')) {
			// clear thumbnail folder
			$this->clearThumbnails();

			// generate the thumbnails
			$this->generateThumbnails();

			// generate the view
			$this->generateView();
		}
	}

	/**
	 * clear the thumbnail folder
	 */
	protected function clearThumbnails() {
		$helper = new Helper();
		$helper->rrmdir(ALBUM_PATH_THUMBNAILS);
		mkdir(ALBUM_PATH_THUMBNAILS);
	}

	/**
	 * Generate the thumbnails
	 */
	protected function generateThumbnails() {
		// create thumb path if it does not exist yet
		if(!file_exists(ALBUM_PATH_THUMBNAILS)) mkdir(ALBUM_PATH_THUMBNAILS);

		// get the phpThumb lib
		require_once './lib/php-thumbnailer/phpThumb.php';

		// new PhpThumb-object
		$thumbnailer = new PhpThumb();

		// get all files in the image directory
		$files = scandir(ALBUM_PATH_ORIGINAL);

		foreach ($files as $file) {
			// skip current & parent folder
			if ($file == '.' || $file == '..') continue;

			// the file path
			$filePath = ALBUM_PATH_ORIGINAL . "/$file";
			$thumbPath = ALBUM_PATH_THUMBNAILS . "/$file";

			// skip if file does not exist of file is directory
			if (!file_exists($filePath) || is_dir($filePath)) continue;

			// generate the thumbnail
			$thumbnailer->init($filePath);
			$thumbnailer->resizeImage(500, 500, 'crop');
			$thumbnailer->saveImage($thumbPath, 100);
		}
	}

	/**
	 * Generate the view
	 */
	protected function generateView() {
		if (!defined('ALBUM_NAME')) define('ALBUM_NAME',ALBUM_FOLDER);

		// scan thumbnail folder
		$files = scandir(ALBUM_PATH_THUMBNAILS);

		$imageString = '';

		foreach ($files as $file) {
			if ($file == '.' || $file == '..') continue;

			// the file path
			$filePath = ALBUM_PATH_ORIGINAL . "/$file";
			$thumbPath = ALBUM_PATH_THUMBNAILS . "/$file";

			// check if both thumbnail & original exist
			if (file_exists($filePath) && file_exists($thumbPath)) {
				$string =
					'<figure class="image">
						<a class="popup" href="/' . ALBUM_FOLDER . '/o/' . $file . '" title="' . $file . '"  >
							<img src="./includes/img/loader.gif" data-src="/' . ALBUM_FOLDER . '/t/' . $file . '" />
						</a>
						<a href="/' . ALBUM_FOLDER . '/d/' . $file . '" title="' . $file . '" class="download" >download</a>
					</figure>';
				$imageString .= $string;
			}
		}

		// oops, error!
		if (!file_exists(INCLUDE_FOLDER . '/templates/show.tpl')) die('Base view not found');

		// set view content
		$content = file_get_contents(INCLUDE_FOLDER . '/templates/show.tpl');
		$content = str_replace('{$content}', $imageString, $content);
		$content = str_replace('{$title}', ALBUM_NAME, $content);


		if (!file_exists(INCLUDE_FOLDER . '/templates/layout.tpl')) die('Base layout not found');
		// set layout content
		$layout = file_get_contents(INCLUDE_FOLDER . '/templates/layout.tpl');
		$layout = str_replace('{$content}', $content, $layout);
		$layout = str_replace('{$title}', ALBUM_NAME, $layout);

		// create view
		$content = $layout;
		$fp = fopen(VIEW_PATH . '/index.html',"wb");
		fwrite($fp,$content);
		fclose($fp);
	}
}