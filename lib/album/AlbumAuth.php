<?php
class AlbumAuth {

	public function auth() {
		// no password set
		if (!defined('ALBUM_PW')) return;

		// skip if authenticated
		if (isset($_SESSION['auth']) && $_SESSION['auth'] == md5(ALBUM_PW . 'jnstr-io')) return;

		$errors = array();
		if (isset($_POST['password'])){
			if ($_POST['password'] == ALBUM_PW) {
				$_SESSION['auth'] = md5(ALBUM_PW . 'jnstr-io');
				return;
			} else {
				$errors[] = 'wrong password';
			}
		}

		// set view content
		$content = file_get_contents(INCLUDE_FOLDER . '/templates/form.tpl');
		$content = str_replace('{$errors}',implode('<br>',$errors),$content);

		$formAction = $_SERVER['PHP_SELF'];
		if (isset($_SERVER['QUERY_STRING'])) {
			$formAction .= "?" . $_SERVER['QUERY_STRING'];
		}
		$content = str_replace('{$action}',$formAction,$content);


		if (!file_exists(INCLUDE_FOLDER . '/templates/layout.tpl')) die('Base layout not found');
		// set layout content
		$layout = file_get_contents(INCLUDE_FOLDER . '/templates/layout.tpl');
		$layout = str_replace('{$content}', $content, $layout);
		$layout = str_replace('{$title}', 'sign in', $layout);
		echo $layout;
		exit;

	}

}