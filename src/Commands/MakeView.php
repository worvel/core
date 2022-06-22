<?php

namespace Core\Commands;

class MakeView extends Command
{
    # command name
    public $tag = "make:view";

    /* --------------------------------------------->
     * View file creater
     * --------------------------------------------->
     *
     * This method creates a View file that is in the
     * resources/view directory.
     *
     * @param string $flag
     *
     * @return String
     *
     */
    public function handle($flag)
    {
        if (!$flag) {
            echo "❌ \e[31mFailed: You didn't specify the name of the view!\n";
            return;
        }

        $flag = $flag[0];

        $viewName = $this->filterFile($flag)->getFileName;
        $viewContent = "<!-- its time to create your view! -->";

        if (
            !$this->createFile(
                get_template_directory() . "/resources/views/" . $flag . ".php",
                $viewContent,
            )
        ) {
            echo "❌ \e[31mFailed to create $viewName view!";
        } else {
            echo "✔ \e[0;32m$viewName view created successfully!\n";
        }
    }
}
