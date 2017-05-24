#!/usr/bin/php

<?php

/**
 * Rip les dossiers d'image pour en faire des cbz
 */
$path = (isset($argv[1])) ? $argv[1] : getcwd();

echo "Path to analyse : {$path}\n";

/**
 * Définition des différent classe utilisé
 */
abstract class FilesystemRegexFilter extends RecursiveRegexIterator {
    protected $regex;
    public function __construct(RecursiveIterator $it, $regex) {
        $this->regex = $regex;
        parent::__construct($it, $regex);
    }
}

class FilenameFilter extends FilesystemRegexFilter {
    // Filter files against the regex
    public function accept() {
        return ( ! $this->isFile() || preg_match($this->regex, $this->getFilename()));
    }
}

/**
 * @param $dir
 *
 * @return RegexIterator
 */
function getImageFromDir($dir) {
    $filesToAdd = array();

    $Directory = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
    $filter = new FilenameFilter($Directory, '/\.(?:png|jpg|jpeg)$/');

    $files = new RecursiveIteratorIterator($filter);
    $files->setMaxDepth(1);

    foreach ($files as $file) {
        $filesToAdd[] = $file;
    }

    return $filesToAdd;
}


/**
 * Fonction qui liste les dossiers contenant des fichiers
 *
 * @param $path
 *
 * @return array
 */
function getDirListToRip($path) {
    $dirs = array();
    $dirsInterator = new RecursiveDirectoryIterator($path, FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS);
    $iterator = new RecursiveIteratorIterator($dirsInterator, RecursiveIteratorIterator::SELF_FIRST);

    foreach($iterator as $file) {
        if (!$iterator->hasChildren(true)) {
            $dirs[] = $iterator->getPath();
        }
    }

    return array_unique($dirs);
}

$dirList = getDirListToRip($path);

foreach ($dirList as $dir) {
    var_dump(getImageFromDir($dir));
}



