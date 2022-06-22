<?php

namespace Core\Commands;

class MakePostType extends Command
{
    # command name
    public $tag = "make:post_type";

    /* --------------------------------------------->
     * Post type creater
     * --------------------------------------------->
     *
     * This method creates/adds new post type in the
     * config/posts.php array.
     *
     * @param string $flag
     *
     * @return String
     *
     */
    public function handle($flag)
    {
        if (!$flag) {
            echo "❌ \e[31mFailed: You didn't specify the name of the post type!\n";
            return;
        }

        $postsFile = get_template_directory() . "/config/posts.php";
        $postName = $flag[0];

        $newPostType =
            "\"$postName\"  => [\n" .
            "        \"label\" => \"" .
            ucfirst($postName) .
            "s\",\n" .
            "        \"labels\" => [\n" .
            "            \"name\" => __(\"" .
            ucfirst($postName) .
            "s\"),\n" .
            "            \"singular_name\" => __(\"" .
            ucfirst($postName) .
            "\"),\n" .
            "         ],\n" .
            "        \"public\" => true,\n" .
            "        \"show_ui\" => true,\n" .
            "        \"has_archive\" => true,\n" .
            "        \"rewrite\" => [\"slug\" => \"" .
            strtolower($postName) .
            "s\"],\n" .
            "        \"show_in_rest\" => true,\n" .
            "    ],\n];";

        $posts = trim(file_get_contents($postsFile));
        $updatePosts = substr($posts, 0, -2);
        $updatedPosts = $updatePosts .= "    " . $newPostType;
        file_put_contents($postsFile, $updatedPosts);

        echo "✔ \e[0;32m$postName post type created successfully!\n";
    }
}
