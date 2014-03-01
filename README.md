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

**As from 2014-03-01, this photo albums no supports multiple albums within the same project.**


how?
--------------

If you want to use this photo album on your web space, the only folder that matters to you is the 'albums' folder.

For each album that you want to create, you have to create this folder structure:
albums (this one already exists :) )
├── albumname

│   ├── original

│   ├── thumbnails

│   ├── view

│   ├── config.php



Add you full-res images to the original-folder and use your browser to navigate to the location of the website.
Define the album you want to show by adding the 'album' get-parameter to the url with the name of your album.
Like this: http://www.just-some-non-existing-url.com/?album=albumname

The thumbnails will be generated using the PHP GD extension.
When the thumnbails are generated, an index.html will be generated in the view-folder to speed up future loading of the page.

If you want to rebuild the album (including thumbnails), just add the 'rebuild' get-parameter to the url with a value of 1.
The URL becomes: http://www.just-some-non-existing-url.com/?album=albumname?rebuild=1
This deletes the index.html file in the view-folder, and all the thumbnails to re-create the whole album.
This can come in handy if you want a new album title of if you updated some images.

### configuration

There are 2 configuration options for this album, both can be set in the config.php file.

The first one is the album name. You can define the album name by following code:
`define('ALBUM_NAME','Here comes the album name');`

There is also a possibility to password-protect your album. Define the password like this:
`define('ALBUM_PW', 'p@ssw0rd');`
If you don't want a password for you album, don't define it :)

still to do
--------------

- setup htaccess to prevent browsing to the php-files
- support good old IE8
- update the .htaccess so the url can be http://www.just-some-non-existing-url.com/albumname instead of http://www.just-some-non-existing-url.com/?album=albumname
- make the rebuild more save (so not everybody can fire ?rebuild=1)
- use namespaces
- rewrite some bits
- make it possible to download a zip of all images
- add a download-link on each thumbnail for easier downloading of the image
- Finish this readme
- ...


requirements
--------------

- PHP >=5.3
- PHP GD extension
- Some images to show
