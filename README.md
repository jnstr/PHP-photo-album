PHP photo album
=================================

A simple responsive photo album, written in PHP

what?
--------------

This is a (very) simple photo album, written in PHP.
All you have to do is add photos to the correct folder and PHP does the magic, setup the config file and you're ready to go.

It's responsive, uses unveil.js to lazy-load the thumbnails and uses swipebox to show the hi-res images.

how?
--------------
Clone this project to your webspace root or subdomain (no support for subfolders).

For each new album to create, add a new folder inside the 'albums' folder with this structure:

```
albums (this one already exists)
├── albumname
│   ├── original
│   ├── thumbnails
│   ├── view
│   ├── config.php
```
You only have to add the hi-res images to the 'originals' folder and setup the config file:
```php
<?php
$config = array(
    // The album name
    'name' => 'My album',
    // The password for the album (comment this out if you don't want a password)
    'password' => 'p@ssw0rd'
);
```
Define the album you want to show by adding the album name to the url (e.g. http://www.example.com/albumname).

On first load, the thumbnails and html are rendered. The html does not auto update, so if you changed some of the pictures, you'll have to rebuild the album manually by appending 'rebuild' to the url (e.g. http://www.example.com/albumname/rebuild)

The thumbnails will be generated using the PHP GD extension.
When the thumnbails are generated, an index.html will be generated in the view-folder to speed up future loading of the page.

If you want to rebuild the album (including thumbnails), just add the 'rebuild' to the album url:
The URL becomes: http://www.just-some-non-existing-url.com/albumname/rebuild
This deletes the index.html file in the view-folder, and all the thumbnails to re-create the whole album.
This can come in handy if you want a new album title of if you updated some images.

requirements
--------------

- PHP >=5.3
- PHP GD extension
