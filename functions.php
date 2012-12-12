<?php
register_nav_menu('navigation', 'Navigation');

function get_custom_fields($id) {
  $custom_fields = get_post_meta($id);

  if (is_array($custom_fields)) {
    return array_map(function($field) {
      if (count($field) !== 1) {
        return $field;
      } else {
        return $field[0];
      }
    }, $custom_fields);
  } else {
    return array();
  }
}
