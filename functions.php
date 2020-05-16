<?php

function load_styles()
{
    wp_register_style("style", get_template_directory_uri() . "/style.css", false, "all");
    wp_enqueue_style("style");
}

add_action("wp_enqueue_scripts", "load_styles");


function loadjs()
{
    wp_register_script("customjs", get_template_directory_uri() . "/js/scripts.js", "", 1, true);
    wp_enqueue_script("customjs");
}

add_action("wp_enqueue_scripts", "loadjs");


function remove_admin_login_header()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');



function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}





if (isset($_POST["submit-btn"])) {
    if ($_POST["tas-check"] === "on" && isset($_POST["name"]) && isset($_POST["email"]) && isset($_FILES["image"])) {

        $image = $_FILES["image"];

        $img_name = $image["name"];
        $img_tmp = $image["tmp_name"];
        $img_size = $image["size"];
        $img_error = $image["error"];


        $file_ext = explode(".", $img_name);
        $file_ext = strtolower(end($file_ext));

        $allowed = array("jpg", "png", "jpeg");

        if (in_array($file_ext, $allowed)) {
            if ($img_error === 0) {
                if ($img_size <= 2098152) {

                    $img_new_name = uniqid("", true) . "." . $file_ext;
                    $img_url = "/var/www/html/wordpress/wp-content/uploads/images/" . $img_new_name;

                    move_uploaded_file($img_tmp, $img_url);
                }
            }
        } else {
            die();
        }

        global $wpdb;

        $data_array = array(
            "title" => test_input($_POST["title"]),
            "person_name" => test_input($_POST["name"]),
            "email" => test_input($_POST["email"]),
            "img" => $img_new_name,
            "likes" => 0
        );
        $table_name = "images";

        $row_result = $wpdb->insert($table_name, $data_array, $format = NULL);

        if ($row_result == 1) {
            header("location:" . get_home_url() . "#kuvat");
            die();
        }
    } else {
        //header("location:" . get_home_url() . "#osallistu");
        $bool = true;
    }
}
