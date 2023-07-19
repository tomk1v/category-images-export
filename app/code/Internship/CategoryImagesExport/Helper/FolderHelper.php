<?php

namespace Internship\CategoryImagesExport\Helper;

class FolderHelper
{
    public function ifFolderExist($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public function saveImage($filename, $content)
    {
        file_put_contents($filename, file_get_contents($content->getPath()));
    }
}
