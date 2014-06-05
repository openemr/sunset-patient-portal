<table> 
<?php
//
// Here's a flaw in the way we are "separating logic from user interface".
// In this example the UI needs access to an array shared by the logic.
// Bottom line is, user interfaces have logic too.
//
// So... UI stuff might involve an abstract class with lots of methods and
// subclasses for different UI types.  Here the type would be HTML.
//
foreach(self::_meta as $field_name => $field_label) {
?>
  <tr valign="top">
    <th class="metabox_label_column">
      <label for="<?php echo $field_name; ?>"><?php echo $field_label; ?></label>
    </th>
    <td>
      <input type="text" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" value="<?php echo @get_post_meta($post->ID, $field_name, true); ?>" />
    </td>
  <tr>
<?php } // end foreach ?>
</table>
