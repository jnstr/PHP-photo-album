<?php
Class PhpThumb {

	private $image;
	private $width;
	private $height;
	private $imageResized;

	/**
	 * Construct
	 *
	 * @param $fileName
	 */
	public function __construct($fileName = '') {
		if (!empty($fileName)) {
			$this->init($fileName);
		}
	}

	public function init($fileName) {
		// open file
		$this->image = $this->openImage($fileName);

		// get dimensions
		$this->width  = imagesx($this->image);
		$this->height = imagesy($this->image);
	}

	/**
	 * Open an image by its filename
	 *
	 * @param $file
	 * @return bool|resource
	 */
	protected function openImage($file) {
		// get the image extension
		$extension = strtolower(strrchr($file, '.'));

		switch($extension) {
			case '.jpg':
			case '.jpeg':
				$img = @imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = @imagecreatefromgif($file);
				break;
			case '.png':
				$img = @imagecreatefrompng($file);
				break;
			default:
				$img = false;
				break;
		}
		return $img;
	}

	/**
	 * Resize the image by given width & height
	 *
	 * @param $newWidth
	 * @param $newHeight
	 * @param string $option
	 */
	public function resizeImage($newWidth, $newHeight, $option = "auto") {
		// Get optimal width and height
		$optionArray = $this->getDimensions($newWidth, $newHeight, $option);

		$optimalWidth  = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];


		// Re-sample - create image canvas of x, y size
		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


		// also perform crop if it is asked
		if ($option == 'crop') {
			$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
		}
	}

	/**
	 * Get the dimensions
	 *
	 * @param $newWidth
	 * @param $newHeight
	 * @param $option
	 * @return array
	 */
	private function getDimensions($newWidth, $newHeight, $option) {

	   switch ($option)
		{
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
			case 'crop':
				$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}


	/**
	 * Get the size by a fixed height
	 *
	 * @param $newHeight
	 * @return mixed
	 */
	private function getSizeByFixedHeight($newHeight) {
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}


	/**
	 * Get the size by a fixed width
	 *
	 * @param $newWidth
	 * @return mixed
	 */
	private function getSizeByFixedWidth($newWidth) {
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

	/**
	 * Get the size automatically by given width & height
	 *
	 * @param $newWidth
	 * @param $newHeight
	 * @return array
	 */
	private function getSizeByAuto($newWidth, $newHeight) {
		// landscape
		if ($this->height < $this->width) {
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		}
		// portrait
		elseif ($this->height > $this->width) {
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		}
		// square
		else {
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			} else if ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			} else {
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}


	/**
	 * Calculate the optimal crop ratio
	 *
	 * @param $newWidth
	 * @param $newHeight
	 * @return array
	 */
	private function getOptimalCrop($newWidth, $newHeight) {

		$heightRatio = $this->height / $newHeight;
		$widthRatio  = $this->width /  $newWidth;

		if ($heightRatio < $widthRatio) {
			$optimalRatio = $heightRatio;
		} else {
			$optimalRatio = $widthRatio;
		}

		$optimalHeight = $this->height / $optimalRatio;
		$optimalWidth  = $this->width  / $optimalRatio;

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	/**
	 * Crop the image
	 *
	 * @param $optimalWidth
	 * @param $optimalHeight
	 * @param $newWidth
	 * @param $newHeight
	 */
	private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
		// Determine the center of the image
		$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
		$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

		$crop = $this->imageResized;

		// Crop the image, starting from the center
		$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
		imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
	}

	/**
	 * Save the cropped image
	 *
	 * @param $savePath
	 * @param string $imageQuality
	 */
	public function saveImage($savePath, $imageQuality = "100" ) {
		// get the file extension
		$extension = strrchr($savePath, '.');
		$extension = strtolower($extension);

		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG) {
					imagejpeg($this->imageResized, $savePath, $imageQuality);
				}
				break;

			case '.gif':
				if (imagetypes() & IMG_GIF) {
					imagegif($this->imageResized, $savePath);
				}
				break;

			case '.png':
				// the quality for scaling
				$scaleQuality = round(($imageQuality/100) * 9);

				// Invert quality setting
				$invertScaleQuality = 9 - $scaleQuality;

				if (imagetypes() & IMG_PNG) {
					 imagepng($this->imageResized, $savePath, $invertScaleQuality);
				}
				break;
			default:
				// no extension no party
				break;
		}

		imagedestroy($this->imageResized);
	}

}
