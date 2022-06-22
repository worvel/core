<?php

namespace Core\Commands;

abstract class Command
{
    # command name
    public $tag = "";

    /* --------------------------------------------->
     * File creater
     * --------------------------------------------->
     *
     * This method creates a file with the specified
     * path and content
     *
     * @param string path
     * @param string content
     *
     * @return boolean
     *
     */
    protected function createFile(string $path = null, string $content = "")
    {
        if (!$path) {
            return 0;
        }

        $paths = explode("/", $path);
        $fileName = end($paths);
        $pathOnly = substr($path, 0, -strlen($fileName));

        if (!$path) {
            return 0;
        }

        if (!$fileName) {
            return 0;
        }

        if (!is_dir($pathOnly)) {
            if (!mkdir($pathOnly, 0777, true)) {
                return 0;
            }
        }

        $createFile = fopen($path, "w");
        fwrite($createFile, $content);
        fclose($createFile);

        return 1;
    }

    /* --------------------------------------------->
     * filters commandline flag as file
     * --------------------------------------------->
     *
     * This method filters the flag as a file name and
     * path, it explodes the flag string with "/" the
     * last key makes as a name.
     *
     * @param String flag
     * @return stdObject with name and path props
     *
     */
    protected function filterFile($flag)
    {
        if (!$flag) {
            return 0;
        }

        $flagFilePaths = explode("/", $flag);
        $flagFileName = end($flagFilePaths);
        $flagFilePathOnly = "";

        if (count($flagFilePaths) > 1) {
            foreach ($flagFilePaths as $filePath) {
                if ($filePath !== $flagFileName) {
                    $flagFilePathOnly .= "\\$filePath";
                }
            }
        }

        $flagFilters = new \stdClass();
        $flagFilters->getPathOnly = $flagFilePathOnly;
        $flagFilters->getFileName = $flagFileName;

        return $flagFilters;
    }
}
