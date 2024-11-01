<div class="wpdroid-cross-promotions api-key" style="margin:0px">


  <p class="itemTitle" style="padding-bottom:5px; text-align:center;">Details</p>

  <?php $isValidLicense = get_option('wp_license_valid_droid', 0); ?>
  <span class="heading">License:</span> <span class="value allcaps <?php echo $isValidLicense ? 'green' : 'red'?> "><?php  echo $isValidLicense  ? 'Active' : "Inactive"; ?></span>

  <br>

  <span class="heading">Plan:</span> <span class="value allcaps"><?php  echo $isValidLicense ? get_option('wp_license_droid_plan', 'N/A') : 'N/A'; ?></span>

  <br>

  <span class="heading">Purchased on:</span> <span class="value"><?php  echo $isValidLicense ? get_option('wp_license_droid_purchase_date', 'N/A') : 'N/A'; ?></span>

  <br>

  <span class="heading">Valid until:</span> <span class="value"><?php  echo $isValidLicense ? get_option('wp_license_droid_validuntil', 'N/A') : 'N/A'; ?></span>


  <p class="itemTitle" style="padding-bottom:5px; text-align:center;">Features</p>

  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_pushnotifications', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Push Notifications</span>

  <br>


  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_bookmarks', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Bookmarks</span>

  <br>

  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_admob', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Admob</span>

  <br>



  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_analytics', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Google Analytics</span>

  <br>


  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_categories', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Categories</span>

  <br>


  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_related_posts', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Related Posts</span>

  <br>

  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_comments', 0) ? 'green' : 'red'; ?>"></span> <span class="value">Comments</span>

  <br>


  <span class="heading <?php  echo $isValidLicense && get_option('wp_license_droid_about', 0) ? 'green' : 'red'; ?>"></span> <span class="value">About</span>



</div>
