simple-responsive-php-photo-album
=================================

A simple responsive photo album, written in PHP

This project is still under construction, so use at your own risk (or contribute to fix some bugs)


what?
--------------

This is a (very) simple photo album, written in PHP.
All you have to do is add photos to the correct folder and PHP does the magic :)
It's responsive and uses unveil.js to lazy-load the thumbnails.
Magnific popup is used to show the hi-res images.


how?
--------------

Add your full-res images to the 'album/original' folder and use your browser to navigate to the location where index.php is located.
The thumbnails will be generated using the PHP GD extension.
When the thumnbails are generated, an index.html will be generated in the view-folder to speed up future loading of the page.
If you want to rebuild the album (including thumbnails), just add ?rebuild=1 after your URL.

If you want the album to be password-protected, define ALBUM_PW in the config/config.php file.
If you don't want the alubm to be password-protected, don't define ALBUM_PW in the config/config.php file.

You can set the album title by defining ALBUM_NAME in the config/config.php file.

still to do
--------------

- setup htaccess to prevent browsing to the php-files
- support good old IE8
- make the rebuild more save (so not everybody can fire ?rebuild=1)
- use namespaces
- rewrite some bits
- support multiple albums within the same project
- make it possible to download a zip of all images
- add a download-link on each thumbnail for easier downloading of the image
- Finish this readme
- ...


requirements
--------------

- PHP
- PHP GD extension
- Some images to show
