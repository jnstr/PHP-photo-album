<?php
namespace Jnstr\Album;

// require the setup file
require_once('setup.php');


/**
 * Class Album
 * @package Jnstr\Album
 */
class Album
{
    /** @var string|null the album password */
    private static $password = null;
    /** @var string|null the album name */
    private static $album = null;

    /**
     * Run the album app
     *
     * @static
     */
    public static function run()
    {
        // init the configuration
        self::initConf();
        // initialize the album
        self::initAlbum();
    }

    /**
     * Init the configuration
     */
    private static function initConf()
    {
        // load the config
        $config = new Config();
        $config->load();

        // set config settings
        self::$password = $config->getPassword();
        self::$album = $config->getName();
    }


    /**
     * Init the album (including authentication)
     */
    private static function initAlbum() {
        $auth = new Auth(self::$password);
        // try to grant access
        if (!$auth->hasAccess()) {
            $auth->grantAccess();
        }

        // access -> let's to!
        if ($auth->hasAccess()) {
            // download a file?
            self::initDownload();
            // show album
            self::showAlbum();
        }
    }

    /**
     * Check if we want to download a file
     */
    private static function initDownload()
    {
        if (isset($_GET['file'])) {
            $download = new Download();
            $download->image($_GET['file']);
        }
    }

    /**
     * Show an album (or build one if needed/requested)
     */
    private static function showAlbum() {
        // build the album
        $build = new Builder();
        if ($build->check()) {
            $build->build();
        }

        // view the album
        $viewer = new Viewer();
        $viewer->view();
    }
}