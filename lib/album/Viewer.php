<?php
namespace Jnstr\Album;


/**
 * Class Viewer
 * @package Jnstr\Album
 */
class Viewer {

	/**
	 * Show the album
     */
	public function view() {
		if (!file_exists(VIEW_PATH . '/index.html')) Error::displayErrorPage(404);
		echo (file_get_contents(VIEW_PATH . '/index.html'));
	}

}