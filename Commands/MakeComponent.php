<?php

namespace Core\Commands;

class MakeComponent extends Command
{
    # command name
    public $tag = "make:component";

    /* --------------------------------------------->
     * Component file creater
     * --------------------------------------------->
     *
     * This method creates a Component file that is in the
     * resources/views/components directory.
     *
     * @param string $flag
     *
     * @return String
     *
     */
    public function handle($flag)
    {
        if (!$flag) {
            echo "❌ \e[31mFailed: You didn't specify the name of the component!\n";
            return;
        }

        $flag = $flag[0];

        $componentName = $this->filterFile($flag)->getFileName;
        $componentContent =
            "<div>\n    <!-- its time to create your component! -->\n</div>";

        if (
            !$this->createFile(
                get_template_directory() .
                    "/resources/views/components/" .
                    $flag .
                    ".php",
                $componentContent,
            )
        ) {
            echo "❌ \e[31mFailed to create $componentName component!";
        } else {
            echo "✔ \e[0;32m$componentName component created successfully!\n";
        }
    }
}
