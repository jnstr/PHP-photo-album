<?php
namespace Jnstr\Album;

/**
 * Class Config
 * @package Jnstr\Album
 */
class Config
{

    /**
     * @var string|null the album name
     */
    private $name = null;
    /**
     * @var string|null the album password
     */
    private $password = null;

    /**
     * Get the album name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the album password
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Constructor for the album config
     */
    public function __construct()
    {
        // define the album name
        $this->name = ! isset($_GET['album']) ? $_GET['album'] : null;
        // define the
        $this->password = ! isset($_GET['album']) ? $_GET['album'] : null;
    }

    /**
     * Load the config for the album
     */
    public function load()
    {
        // define the variables
        $this->define();
        // get the config
        $this->getConfig();
    }

    /**
     * Get the config file from the album folder
     *
     * @param $requestUri
     */
    private function getConfig()
    {
        // set the config file
        $config = ALBUM_PATH . "/config.php";
        if (!file_exists($config)) {
            Error::displayErrorPage(404);
        }
        include($config);

        // set the album name
        if (isset($config['name'])) {
            $this->name = $config['name'];
        } else if (defined('ALBUM_NAME')) {
            $this->name = ALBUM_NAME;
        }

        // set the album password
        if (isset($config['password'])) {
            $this->password = $config['password'];
        } else if (defined('ALBUM_PW')) {
            $this->password = ALBUM_PW;
        }
    }

    /**
     * Define the variables
     *
     * @param $requestUri
     */
    private function define()
    {
        // general include folder (for tpl, js, css... files)
        define ("INCLUDE_FOLDER", $_SERVER['DOCUMENT_ROOT'] . "/includes");

        // define the album folder name
        if ( ! isset($_GET['album'])) Error::displayErrorPage(404);
        define('ALBUM_FOLDER', $_GET['album']);

        // define the path for the view files
        define("VIEW_PATH", $_SERVER['DOCUMENT_ROOT'] . "/albums/" . ALBUM_FOLDER . "/view");

        // the path for the album
        define("ALBUM_PATH", str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . "/albums/" . ALBUM_FOLDER . "/"));
        // does the album folder exist?
        if ( ! is_dir(ALBUM_PATH)) Error::displayErrorPage(404);

        // the path where the images are stored
        define("ALBUM_PATH_ORIGINAL", ALBUM_PATH . '/original');
        define("ALBUM_PATH_THUMBNAILS", ALBUM_PATH . '/thumbnails');
    }
}