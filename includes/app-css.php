<?php

function wpdroid_plugin_app_css_screen() {

    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    if(!get_option('wp_license_valid_droid', 0)) {
       include WP_DROID_PLUGIN_DIR . '/includes/helpers/invalid-license-layout.php';
       return;
    }

    ?>

     <div class="columnsContainer">

      <div class="leftColumn">

      <form method="post" action="">

      <?php

         wp_nonce_field('wp--droid-app-css', 'wp--droid', FALSE, TRUE);

          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['wp--droid-css-update'])) {

              check_admin_referer('wp--droid-app-css', 'wp--droid');

              if (!current_user_can('manage_options'))  {
                 wp_die( __('You do not have sufficient permissions to access this page.') );
              }

              if(isset($_POST['wp--droid-css-update'])) {
                wpdroid_save_option('wpdroid_app_custom_css',  sanitize_textarea_field(stripslashes($_POST['wpdroid_app_css'])));
              }

        }
     ?>

        <ul>
          <li class="itemDetail" style="display: list-item;">
            <h2 class="itemTitle">Custom CSS for App (Detailed Article screen)</h2>
            <p class="wp_droid_subheading">Add your own CSS for the app. This CSS will be applied to Detailed article screen. Keep it simple and clean. Adding complex CSS will make the app slower</p>
              <table>
                <tbody>

                  <tr>

                    <td>
                      <TEXTAREA autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="wp_droid_custom_css" id="wpdroid_app_css" name="wpdroid_app_css" rows="30" cols="70" wrap="hard"><?php $css = get_option('wpdroid_app_custom_css',wpdroid_DEFAULT_APP_CSS);echo stripslashes($css);?></TEXTAREA>
                    </td>
                  </tr>

                  <tr>
                    <td style="text-align: center; margin-top:20px">
                      <button type="submit" class="wp_droid_button" name="wp--droid-css-update">Update CSS</button>
                    </td>
                    </tr>

                </tbody>
              </table>
            </li>
          </ul>

  	</form>
  </div>


  <div class="rightColumn">
    <div class="rightColumn promotions">
        <div style="margin-top: 2.5em;"></div>

        <?php include(WP_DROID_PLUGIN_DIR . '/includes/helpers/sidebar-common.php'); ?>

    </div>

  </div>

</div>

<?php
}
?>
