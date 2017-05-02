#!/usr/bin/php

<?php

/**
 * Rip les dossiers d'image pour en faire des cbz
 */

echo getcwd() . "\n";

$path = (isset($argv[1])) ? $argv[1] : getcwd();

/**
 * Compresse le dossier
 */
function _doCbz($folder) {
    echo $folder->getfilename()."\n";
}



$iterator = new RecursiveDirectoryIterator($path, FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS); 
foreach($iterator as $file) {
    if (!$iterator->hasChildren()) {
        var_dump($iterator->current());
        //_doCbz($file);
    }
}


