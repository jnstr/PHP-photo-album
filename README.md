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

requirements
--------------

- PHP >=5.3
- PHP GD extension
