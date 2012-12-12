<?php
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

set_include_path(__DIR__ . PS . get_include_path());

if ($post) {
  $post->fields = get_custom_fields($post->ID);
}
