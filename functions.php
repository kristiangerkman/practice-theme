<?php

function fileLoader() {
    wp_enqueue_style("mainStyles", get_stylesheet_uri());
}

add_action("wp_enqueue_scripts", "fileLoader");
