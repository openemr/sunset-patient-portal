<?php
/*
Copyright 2014 Rod Roark (email: rod@sunsetsystems.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!class_exists('Sunset_PP_HTML')) {
  class Sunset_PP_HTML {

    public static function generate_metabox($post_id, $fields) {
      $s = "<table>\n";
      foreach($fields as $field_name => $field_label) {
        $value = @get_post_meta($post_id, $field_name, true);
        $s .= "  <tr valign='top'>\n";
        $s .= "    <th class='metabox_label_column'>\n";
        $s .= "      <label for='$field_name'>$field_label</label>\n";
        $s .= "    </th>\n";
        $s .= "    <td>\n";
        $s .= "      <input type='text' id='$field_name' name='$field_name' value='$value' />\n";
        $s .= "    </td>\n";
        $s .= "  <tr>\n";
      }
      $s .= "</table>\n";
      return $s;
    }

  } // END class Sunset_PP_HTML
} // END if (!class_exists('Sunset_PP_HTML'))

