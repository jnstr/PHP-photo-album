<?php
class Helper {

	/**
	 * Recursively remove a directory
	 *
	 * @param $dir
	 */
	public function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if (substr($object, 0, 1) !== '.') {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}

}