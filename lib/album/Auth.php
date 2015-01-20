<?php
namespace Jnstr\Album;


/**
 * Class Auth
 * @package Jnstr\Album
 */
class Auth {

	/**
	 * @var string|null the password
     */
	private $password = null;

	/**
	 * Constructor
	 * set the password for authenticating
	 *
	 * @param string|null $password
     */
	public function __construct($password = null) {
		$this->password = $password;
	}

	/**
	 * Check if the user has access to the album
	 *
	 * @return bool
     */
	public function hasAccess() {
		$emptyPassword = (bool)(!isset($this->password) || is_null($this->password));
		$authenticated = (bool)(isset($_SESSION['auth']) && $_SESSION['auth'] == $this->getPasswordHash());

		return (bool)($emptyPassword || $authenticated);
	}

	/**
	 * Try to authenticate the user
	 */
	public function grantAccess() {
		$errors = array();
		if (isset($_POST['password'])){
			if ($_POST['password'] == $this->password) {
				$_SESSION['auth'] = $this->getPasswordHash();
				return;
			} else {
				$errors[] = 'wrong password';
			}
		}

		// set view content
		$content = file_get_contents(INCLUDE_FOLDER . '/templates/form.tpl');
		$content = str_replace('{$errors}',implode('<br>',$errors),$content);

		if (isset($_SERVER['REQUEST_URI'])) {
			$formAction = $_SERVER['REQUEST_URI'];
		} else {
			$formAction = '/';
		}
		$content = str_replace('{$action}',$formAction,$content);


		if (!file_exists(INCLUDE_FOLDER . '/templates/layout.tpl')) die('Base layout not found');
		// set layout content
		$layout = file_get_contents(INCLUDE_FOLDER . '/templates/layout.tpl');
		$layout = str_replace('{$content}', $content, $layout);
		$layout = str_replace('{$title}', 'sign in', $layout);
		echo $layout;
	}

	/**
	 * Get the hashed password
	 *
	 * @return string
     */
	private function getPasswordHash() {
		$salt = 'jnstr-io';
		return hash('sha256', $this->password . $salt);
	}

}