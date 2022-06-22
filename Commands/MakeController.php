<?php

namespace Core\Commands;

class MakeController extends Command
{
    # command name
    public $tag = "make:controller";

    /* --------------------------------------------->
     * Controller file creater
     * --------------------------------------------->
     *
     * This method creates a controller file that in
     * the theme/Controllers directory.
     *
     * @param string $flag
     *
     * @return String
     *
     */
    public function handle($flag)
    {
        if (!$flag) {
            echo "❌ \e[31mController name cannot be empty!\n";
            return;
        }

        $flag = $flag[0];

        $controllerName = $this->filterFile($flag)->getFileName;
        $controllerContent =
            "<?php \n\nnamespace Theme\Controllers" .
            $this->filterFile($flag)->getPathOnly .
            ";\n\nclass " .
            $controllerName .
            "\n{\n    # Everything starts from nothing!\n}";

        if (
            !$this->createFile(
                get_template_directory() .
                    "/theme/Controllers/" .
                    $flag .
                    ".php",
                $controllerContent,
            )
        ) {
            echo "❌ \e[31mFailed to create $controllerName controller!";
        } else {
            echo "✔ \e[0;32m$controllerName controller created successfully!\n";
        }
    }
}
