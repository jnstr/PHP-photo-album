<?php
class Error {

	/**
	 * Display an error page (or don't if it does not exist)
	 *
	 * @param $errorCode
	 */
	public static function displayErrorPage($errorCode) {
		// error code should be a number
		$errorCode = intval($errorCode);
		// set the header
		$msg = self::setHeader($errorCode);


		$templatefolder = INCLUDE_FOLDER . '/templates';
		if (defined('INCLUDE_FOLDER') && is_dir($templatefolder) && file_exists("$templatefolder/layout.tpl") && file_exists("$templatefolder/$errorCode.tpl")) {
			// get the view content
			$content = file_get_contents(INCLUDE_FOLDER . "/templates/$errorCode.tpl");

			// set layout content
			$layout = file_get_contents(INCLUDE_FOLDER . '/templates/layout.tpl');
			$layout = str_replace('{$content}', $content, $layout);
			$layout = str_replace('{$title}', "Error $errorCode: $msg", $layout);
			echo $layout;
			exit;
		}
		// could not create the error view
		die("Error $errorCode: $msg");
	}


	/**
	 * Set the correct php header by the given error code
	 *
	 * @param $code
	 * @return string
	 */
	private static function setHeader($code) {
		switch ($code) {
			case 100: $value = 'Continue'; break;
			case 101: $value = 'Switching Protocols'; break;
			case 102: $value = 'Processing'; break;
			case 200: $value = 'OK'; break;
			case 201: $value = 'Created'; break;
			case 202: $value = 'Accepted'; break;
			case 203: $value = 'Non-Authoritative Information'; break;
			case 204: $value = 'No Content'; break;
			case 205: $value = 'Reset Content'; break;
			case 206: $value = 'Partial Content'; break;
			case 207: $value = 'Multi-Status'; break;
			case 300: $value = 'Multiple Choices'; break;
			case 301: $value = 'Moved Permanently'; break;
			case 302: $value = 'Found'; break;
			case 303: $value = 'See Other'; break;
			case 304: $value = 'Not Modified'; break;
			case 305: $value = 'Use Proxy'; break;
			case 307: $value = 'Temporary Redirect'; break;
			case 400: $value = 'Bad Request'; break;
			case 401: $value = 'Unauthorized'; break;
			case 402: $value = 'Payment Required'; break;
			case 403: $value = 'Forbidden'; break;
			case 404: $value = 'Not Found'; break;
			case 405: $value = 'Method Not Allowed'; break;
			case 406: $value = 'Not Acceptable'; break;
			case 407: $value = 'Proxy Authentication Required'; break;
			case 408: $value = 'Request Timeout'; break;
			case 409: $value = 'Conflict'; break;
			case 410: $value = 'Gone'; break;
			case 411: $value = 'Length Required'; break;
			case 412: $value = 'Precondition Failed'; break;
			case 413: $value = 'Request Entity Too Large'; break;
			case 414: $value = 'Request-URI Too Long'; break;
			case 415: $value = 'Unsupported Media Type'; break;
			case 416: $value = 'Requested Range Not Satisfiable'; break;
			case 417: $value = 'Expectation Failed'; break;
			case 422: $value = 'Unprocessable Entity'; break;
			case 423: $value = 'Locked'; break;
			case 424: $value = 'Failed Dependency'; break;
			case 426: $value = 'Upgrade Required'; break;
			case 500: $value = 'Internal Server Error'; break;
			case 501: $value = 'Not Implemented'; break;
			case 502: $value = 'Bad Gateway'; break;
			case 503: $value = 'Service Unavailable'; break;
			case 504: $value = 'Gateway Timeout'; break;
			case 505: $value = 'HTTP Version Not Supported'; break;
			case 506: $value = 'Variant Also Negotiates'; break;
			case 507: $value = 'Insufficient Storage'; break;
			case 509: $value = 'Bandwidth Limit Exceeded'; break;
			case 510: $value = 'Not Extended'; break;
			default: return 'General error';
		}
		header($_SERVER['SERVER_PROTOCOL'] . $code . ' ' . $value, true, $code);
		return $value;
	}


}