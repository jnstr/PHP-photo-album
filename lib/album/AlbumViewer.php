<?php
class AlbumViewer {

	public function view() {
		if (!file_exists(VIEW_PATH . '/index.html')) Error::displayErrorPage(404);
		echo (file_get_contents(VIEW_PATH . '/index.html'));
	}

}