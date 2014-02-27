<?php
class AlbumViewer {

	public function view() {
		if (!file_exists(VIEW_PATH . '/index.html')) die('view not found!');
		echo (file_get_contents(VIEW_PATH . '/index.html'));
	}

}