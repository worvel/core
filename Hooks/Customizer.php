<?php

namespace Core\Hooks;

class Customizer
{
    public function init()
    {
        add_action("customize_register", [$this, "registerCustomizer"]);
    }

    public function registerCustomizer($customizer)
    {
        $customizerParts = require get_template_directory() .
            "/config/customizer.php";

        $panels = $customizerParts["panels"];
        $sections = $customizerParts["sections"];
        $settings = $customizerParts["settings"];
        $controls = $customizerParts["controls"];

        if (is_array($panels) && count($panels) > 0) {
            foreach ($panels as $key => $data) {
                $customizer->add_panel($key, $data);
            }
        }

        if (is_array($sections) && count($sections) > 0) {
            foreach ($sections as $key => $data) {
                $customizer->add_section($key, $data);
            }
        }

        if (is_array($settings) && count($settings) > 0) {
            foreach ($settings as $key => $data) {
                $customizer->add_setting($key, $data);
            }
        }

        if (is_array($controls) && count($controls) > 0) {
            foreach ($controls as $key => $data) {
                $customizer->add_control(
                    $data["control_class"]
                        ? new $data["control_class"]($customizer, $key, $data)
                        : new \WP_Customize_Control($customizer, $key, $data),
                );
            }
        }
    }
}
