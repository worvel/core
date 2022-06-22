<?php

namespace Core\Commands;

class MakeTaxonomy extends Command
{
    # command name
    public $tag = "make:taxonomy";

    /* --------------------------------------------->
     * Taxonomy creater
     * --------------------------------------------->
     *
     * This method creates/adds new taxonomy type in the
     * config/taxonomies.php array.
     *
     * @param string $flag
     *
     * @return String
     *
     */
    public function handle($flag)
    {
        if (!$flag) {
            echo "❌ \e[31mFailed: You didn't specify the name of the taxonomy!\n";
            return;
        }

        if (!$flag[1]) {
            echo "❌ \e[31mFailed: You didn't specify the taxonomy object types!\n";
            return;
        }

        $taxonomyFile = get_template_directory() . "/config/taxonomies.php";
        $taxonomyName = $flag[0];

        $objects = explode(",", $flag[1]);
        $taxonomyObjects = "";

        foreach ($objects as $object) {
            $taxonomyObjects .= "\"" . $object . "\",";
        }

        $newTaxonomy =
            "\"$taxonomyName\" => [\n" .
            "        \"object_type\" => [{$taxonomyObjects}],\n" .
            "        \"args\" => [\n" .
            "            \"hierarchical\" => true,\n" .
            "            \"labels\" => [\n" .
            "                \"name\" => _x(\"{$taxonomyName}s\", \"{$taxonomyName}s\"),\n" .
            "                \"singular_name\" => _x(\"$taxonomyName\", \"$taxonomyName\"),\n" .
            "                \"search_items\" => __(\"Search {$taxonomyName}s\"),\n" .
            "                \"all_items\" => __(\"All {$taxonomyName}s\"),\n" .
            "                \"parent_item\" => __(\"Parent $taxonomyName\"),\n" .
            "                \"parent_item_colon\" => __(\"Parent $taxonomyName:\"),\n" .
            "                \"edit_item\" => __(\"Edit $taxonomyName\"),\n" .
            "                \"update_item\" => __(\"Update $taxonomyName\"),\n" .
            "                \"add_new_item\" => __(\"Add New $taxonomyName\"),\n" .
            "                \"new_item_name\" => __(\"New $taxonomyName\"),\n" .
            "                \"menu_name\" => __(\"{$taxonomyName}s\"),\n" .
            "            ],\n" .
            "            \"show_ui\" => true,\n" .
            "            \"show_in_rest\" => true,\n" .
            "            \"rewrite\" => [\n" .
            "                \"slug\" => \"$taxonomyName\",\n" .
            "                \"with_front\" => false,\n" .
            "            ],\n" .
            "        ],\n" .
            "    ],";

        $taxonomies = trim(file_get_contents($taxonomyFile));
        $updateTaxonomies = substr($taxonomies, 0, -2);
        $updatedTaxonomies = $updateTaxonomies .=
            "\n    " . $newTaxonomy . "\n];";
        file_put_contents($taxonomyFile, $updatedTaxonomies);

        echo "✔ \e[0;32m$taxonomyName taxonomy created successfully!\n";
    }
}
