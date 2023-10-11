<?php
/**
 * Category Images Export
 *
 * @category  Internship
 * @package   Internship\CategoryImagesExport
 * @author    Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2023 tomk1v
 */

namespace Internship\CategoryImagesExport\Helper;

class FolderHelper
{
    /**
     * @param $dir
     * @return void
     */
    public function ifFolderExist($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    /**
     * @param $filename
     * @param $content
     * @return void
     */
    public function saveImage($filename, $content)
    {
        file_put_contents($filename, file_get_contents($content->getPath()));
    }
}
