<div class="wrap">
    <h2>WP Plugin Template</h2>
    <form method="post" action="options.php">

        <?php
          // http://codex.wordpress.org/Function_Reference/settings_fields
          // Output nonce, action, and option_page fields for a settings page.
          // These are hidden form fields global to the form. This function must
          // be called inside of the form tag for the options page.
          // Argument should match the group name used in register_setting().
          //
          @settings_fields('sunsetpatientportal-group');
        ?>

        <?php
          // http://codex.wordpress.org/Function_Reference/do_settings_sections
          // Prints out ALL settings sections added to a particular settings page.
          // First arg is the slug name of the page whose settings sections you want to output.
          // It should match the page name used in add_settings_section().
          // This will output the section titles wrapped in h3 tags and the settings fields wrapped in tables.
          //
          do_settings_sections('sunsetpatientportal');
        ?>

        <?php
          // http://codex.wordpress.org/Function_Reference/submit_button
          // Echos a submit button, with provided text and appropriate class.
          // This function is only available from the administration panels.
          // It cannot be used on the front end of the site.
          // There are various optional arguments.
          //
          @submit_button();
        ?>

    </form>
</div>
