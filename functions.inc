<?php

/**
 * Finds path, relative to the given root folder, of all files and directories in the given directory and its sub-directories non recursively.
 * Will return an array of the form
 * array(
 *   'files' => [],
 *   'dirs'  => [],
 * )
 * @author sreekumar
 * @param string $root
 * @result array
 */
function read_all_files($root = '.'){
  $files  = array('files'=>array(), 'dirs'=>array());
  $directories  = array();
  $last_letter  = $root[strlen($root)-1];
  $root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;

  //$directories[]  = $root;

  //while (sizeof($directories)) {
    $dir  = $root;//array_pop($directories);
    if ($handle = @opendir($dir)) {
      while (false !== ($file = readdir($handle))) {
        if ($file == '.' || $file == '..') {
          continue;
        }
        $file  = $dir.$file;
        if (is_dir($file)) {
          $directory_path = $file.'/';
          //array_push($directories, $directory_path);
          $files['dirs'][]  = $directory_path;
        } elseif (is_file($file)) {
          $files['files'][]  = $file;
        }
      }
      closedir($handle);
    } else {
        $files['error'] = 'Could not find the specified album: ' . htmlspecialchars($dir);
    };
  //}

  return $files;
}

function make_thumb($src, $dest, $desired_width) {

    /* read the source image */
    switch(strtolower(pathinfo($src, PATHINFO_EXTENSION))){
        case 'jpg':
        case 'jpeg':
            $source_image = imagecreatefromjpeg($src);
            break;
        case 'png':
            $source_image = imagecreatefrompng($src);
            break;
        case 'gif':
            $source_image = imagecreatefromgif($src);
            break;
        default:
            echo('Filetype for: '.$src.' unknown.');
            die();
    };

    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    imagejpeg($virtual_image, $dest);
}
?>
