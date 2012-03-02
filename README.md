CakePHP-ImageUploader
=============

This component aims to be a simple, lightweight and non intrusive for all CakePHP Images-related works.

Tested and developed on CakePHP-2.1-RC1

Installation
-------

* Copy `ImageUploadComponent` in your `app/Controller/Component/` folder in your CakePHP application.
* Include `var $components = array("Imageupload");` just after Class/Controller declaration.

Setting Up
-------

This is the list of parameters that you can modify in the component to achieve your goals.

### $upload_folder
Default is set `uploads/` in your webroot, change that on your need. In this folder ( that for this version you need to create manually ) there must be two other folders `thumbs/` and `original/`

### $original_size
This is the size that you want original image are resized to. ( The longer side will be resized to this parameter and afet proportionally will be resized also the other side whitout losing aspect ratio )

### $thumb_size
This is the size that you want thumbnails image are resized to. ( The longer side will be resized to this parameter and afet proportionally will be resized also the other side whitout losing aspect ratio )

Using the Component
-------

This section will be filled in the further commits. sorry guys :)

Contributing
------------

1. Fork it.
2. Create a branch (`git checkout -b CakePHP-ImageUploader`)
3. Commit your changes (`git commit -am "Added Unicorns"`)
4. Push to the branch (`git push origin CakePHP-ImageUploader`)
5. Create an [Issue][1] with a link to your branch
6. Enjoy a cup of coffee. :)

