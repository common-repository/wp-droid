<?php

function wpdroid_plugin_push_notifications_settings_screen()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    if (!get_option('wp_license_valid_droid', 0)) {
        include WP_DROID_PLUGIN_DIR . '/includes/helpers/invalid-license-layout.php';
        return;
    } ?>

<div class="columnsContainer">
	<div class="leftColumn">
		<div class="wrap itemDetail">


			<form id="wp_droid_notification" action="" method="post">

				<h2 class="itemTitle">Send Push Notifications to All Android Users</h2>

				<?php

                        wp_nonce_field('wp--droid-notifications', 'wp--droid', false, true);

    if (isset($_POST['wp--droid-notifications-update'])) {
        check_admin_referer('wp--droid-notifications', 'wp--droid');

        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
    }

    $json = '';
    $response = '';

    require_once(WP_DROID_PLUGIN_DIR . '/includes/api/notifications-api.php');


    if (isset($_REQUEST['notificationtype'])) {
        $notificationType = $_REQUEST['notificationtype'];
        switch ($notificationType) {
                                                    case 'new-post':


                                                    $title = isset($_REQUEST['post-title']) && $_REQUEST['post-title'] != '' ? $_REQUEST['post-title'] : 'default';

                                                    $message = isset($_REQUEST['post-description']) && $_REQUEST['post-description'] != '' ? $_REQUEST['post-description'] : 'default';

                                                    $image = isset($_REQUEST['post-image']) && $_REQUEST['post-image'] != '' ? $_REQUEST['post-image'] : 'default';


                                                    $postid = isset($_REQUEST['post-id']) && $_REQUEST['post-id'] != '' ? $_REQUEST['post-id'] : -1;



                                                    $oneSignalPush = new WPDroidPush();

                                                    $oneSignalPush->setTitle($title);
                                                    $oneSignalPush->setDescription($message);
                                                    $oneSignalPush->setImage($image);
                                                    $oneSignalPush->setPostId($postid);

                                                                $oneSignalPush->setNotificationType('new_post');

                                                    $oneSignalPush->sendNotification();


                                                    break;

                                                    case 'announcement':


                                                    $title = isset($_REQUEST['announcement-title']) && $_REQUEST['announcement-title'] != ''? $_REQUEST['announcement-title'] : 'default';

                                                    $message = isset($_REQUEST['announcement-description']) && $_REQUEST['announcement-description'] != '' ? $_REQUEST['announcement-description'] : 'default';


                                                    $announcementImage = isset($_REQUEST['announcement-image']) && $_REQUEST['announcement-image'] != '' ? $_REQUEST['announcement-image'] : 'default';


                                                    $announcementURL = isset($_REQUEST['announcement-url']) && $_REQUEST['announcement-url'] !== '' ? $_REQUEST['announcement-url'] : 'default';


                                                    $oneSignalPush = new WPDroidPush();



                                                    $oneSignalPush->setTitle($title);
                                                    $oneSignalPush->setDescription($message);
                                                    $oneSignalPush->setImage($announcementImage);
                                                    $oneSignalPush->setURL($announcementURL);

                                                                $oneSignalPush->setNotificationType('announcement');

                                                    $oneSignalPush->sendNotification();


                                                    break;

                                                    case 'update':


                                                        $title = 'New update available';
                                                        $message = 'Update the app for more features and improvements';
                                                        $image = 'default';

                                                        $update_type = isset($_REQUEST['update_type']) && $_REQUEST['update_type'] != ''? $_REQUEST['update_type'] : 'default';

                                                        $latestVersionCode = -1;
                                                        $lastForceUpdateVersionCode = 1;

                                                        if (isset($_REQUEST[INPUT_LATEST_VERSION_CODE]) && $_REQUEST[INPUT_LATEST_VERSION_CODE] != '') {
                                                            wpdroid_save_option(INPUT_LATEST_VERSION_CODE, $_REQUEST[INPUT_LATEST_VERSION_CODE]);

                                                            if ($update_type == 'force_update') {
                                                                wpdroid_save_option(INPUT_LAST_FORCE_UPDATE_VERSION_CODE, $_REQUEST[INPUT_LATEST_VERSION_CODE]);
                                                            }
                                                            $latestVersionCode = get_option(INPUT_LATEST_VERSION_CODE, -1);
                                                            $lastForceUpdateVersionCode = get_option(INPUT_LAST_FORCE_UPDATE_VERSION_CODE, 1);
                                                        }


                                                                $oneSignalPush = new WPDroidPush();


                                                        $oneSignalPush->setTitle($title);
                                                        $oneSignalPush->setDescription($message);
                                                        $oneSignalPush->setImage($image);

                                                                    $oneSignalPush->setNotificationType('update');
                                                                    $oneSignalPush->setUpdateType($update_type);
                                                                    $oneSignalPush->setLatestVersionCode($latestVersionCode);
                                                                    $oneSignalPush->setLastForceUpdateCode($lastForceUpdateVersionCode);


                                                        $oneSignalPush->sendNotification();

                                                        break;

                                                    case 'clear-cache':


                                                        $title = 'Refreshing app content';
                                                        $message = 'Tap to open the app';
                                                        $image = 'default';

                                                        // $url_to_clear = isset($_REQUEST[INPUT_CLEAR_URL_CACHE]) && $_REQUEST[INPUT_CLEAR_URL_CACHE] != ''? $_REQUEST[INPUT_CLEAR_URL_CACHE] : 'default';


                                                        $oneSignalPush = new WPDroidPush();

                                                        $oneSignalPush->setTitle($title);
                                                        $oneSignalPush->setDescription($message);
                                                        $oneSignalPush->setImage($image);

                                                                    $oneSignalPush->setNotificationType('clear_app_cache');
                                                                    // $oneSignalPush->setUrlToClear($url_to_clear);

                                                        $oneSignalPush->sendNotification();

                                                         break;

                                                    default: break;
                                                }
    } ?>

					<script type="text/javascript">
						jQuery(document).ready(function($) {


							$("#wp_droid_notification").submit(function() {
								var notificationtype = $("#selectedNotification").val();

								switch (notificationtype) {

									case 'new-post':

										if ($("#wp_droid_post_id").val().trim() == '') {
											alert('Post id can not be empty');
											return false;
										}

										if ($("#wp_droid_post_title").val().trim() == '') {
											alert('Post Title can not be empty');
											return false;
										}

										if ($("#wp_droid_post_description").val().trim() == '') {
											alert('Post Description can not be empty');
											return false;
										}

										break;


									case 'announcement':

										if ($("#wp_droid_announcement_title").val().trim() == '') {
											alert('Announcement title can not be empty');
											return false;
										}

										if ($("#wp_droid_announcement_description").val().trim() == '') {
											alert('Announcement description can not be empty');
											return false;
										}

										if ($("#wp_droid_announcement_url").val().trim() == '') {
											alert('Announcement URL can not be empty');
											return false;
										}

										break;

								}

							});


							$("select").change(function() {
								$(this).find("option:selected").each(function() {
									var optionValue = $(this).attr("value");
									if (optionValue) {
										$(".notification-type").not("." + optionValue).hide();
										$("." + optionValue).show();
									} else {
										$(".notification-type").hide();
									}
								});
							}).change();
						});



					</script>

					<table class="form-table wpdroid-notifications-status">
						<tbody>
							<tr>
								<th class="wp_droid_th">Notification type</th>
								<td>
									<div>
										<select class="wp_droid_input" name="notificationtype" id="selectedNotification">
													<option value="default">Choose Notification type</option>
													<option value="new-post">New Post</option>
													<option value="announcement">Announcement</option>
													<!-- <option value="update">App Update</option> -->
													<option value="clear-cache">Clear App Cahce</option>
												</select>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- Form table -->


					<div class="new-post notification-type">
						<table class="form-table">
							<tbody>


								<tr>
									<th class="wp_droid_th">Post Id</th>
									<td> <input class="wp_droid_input" id="wp_droid_post_id" type="number" name="post-id" placeholder="Enter post id" size="60" maxlength="20">
										<p class="notification-field-description">On clicking the notification, detailed article screen will be shown</p>
									</td>
								</tr>


								<tr>
									<th class="wp_droid_th">Post title</th>
									<td> <input class="wp_droid_input" id="wp_droid_post_title" type="text" name="post-title" placeholder="Enter notification title" maxlength="250" size="60">
										<p class="notification-field-description">This will be the title of your notification. Keep it short and attracrive</p>
									</td>
								</tr>

								<tr>
									<th class="wp_droid_th">Post Description</th>
									<td> <textarea class="wp_droid_input" id="wp_droid_post_description" name="post-description" rows="3" cols="60" placeholder="Enter your notification description" maxlenth="1000" class="notification-text-area-field"></textarea>
										<p class="notification-field-description">This will be shown below post title.</p>
									</td>
								</tr>


								<tr>
									<th class="wp_droid_th">Image (Optional)</th>
									<td>

										<?php
if (isset($_POST['submit_image_selector']) && isset($_POST['image_attachment_id'])) :
        update_option('media_selector_attachment_id', absint($_POST['post-image']));
    endif;
    wp_enqueue_media(); ?>

											<form method='post'>
												<div class='image-preview-wrapper'>
													<img id='image-preview' src='<?php echo wp_get_attachment_url(get_option(' media_selector_attachment_id ')); ?>' style="widht:70%;height:auto;">
												</div>
												<input id="upload_image_button" type="button" class="button" value="<?php _e('Upload image'); ?>" />
											</form>
											<?php
$my_saved_attachment_post_id = get_option('media_selector_attachment_id', 0); ?>
												<script type='text/javascript'>
													jQuery(document).ready(function($) {
														// Uploading files
														var file_frame;
														var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
														var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
														jQuery('#upload_image_button').on('click', function(event) {
															event.preventDefault();
															// If the media frame already exists, reopen it.
															if (file_frame) {
																// Set the post ID to what we want
																file_frame.uploader.uploader.param('post_id', set_to_post_id);
																// Open frame
																file_frame.open();
																return;
															} else {
																// Set the wp.media post id so the uploader grabs the ID we want when initialised
																wp.media.model.settings.post.id = set_to_post_id;
															}
															// Create the media frame.
															file_frame = wp.media.frames.file_frame = wp.media({
																title: 'Select featured image',
																button: {
																	text: 'Use this image',
																},
																multiple: false // Set to true to allow multiple files to be selected
															});
															// When an image is selected, run a callback.
															file_frame.on('select', function() {
																// We set multiple to false so only get one image from the uploader
																attachment = file_frame.state().get('selection').first().toJSON();
																// Do something with attachment.id and/or attachment.url here
																$('#image-preview').attr('src', attachment.url).css({
																	"max-width": "300px",
																	"height": "auto"
																});
																$('#post-image').val(attachment.url);

																// Restore the main post ID
																wp.media.model.settings.post.id = wp_media_post_id;
															});
															// Finally, open the modal
															file_frame.open();
														});
														// Restore the main ID when the add media button is pressed
														jQuery('a.add_media').on('click', function() {
															wp.media.model.settings.post.id = wp_media_post_id;
														});
													});
												</script>





												<input class="wp_droid_input" type='hidden' size="60" name='post-image' id='post-image'>
												<p class="notification-field-description">Leave empty if you want to send "Small Notification". If image is selected, "Big Picture Notification" will be sent.</p>
									</td>
								</tr>

								<tr>
									<td></td>
									<th class="wp_droid_th">
										<button name="wp--droid-notifications-update" type="submit" class="wp_droid_button">Send Notification</button>
									</th>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- New Post -->


					<div class="announcement notification-type">
						<table class="form-table">
							<tbody>
								<tr>
									<th class="wp_droid_th">Announcement title</th>
									<td> <input class="wp_droid_input" id="wp_droid_announcement_title" type="text" name="announcement-title" placeholder="Enter announcement title" maxlength="250" size="60">
										<p class="notification-field-description"><strong>Example: </strong>Happy New Year
											<?php print_r(date('Y')) ?>
										</p>
									</td>
								</tr>

								<tr>
									<th class="wp_droid_th">Announcement Description</th>
									<td> <textarea class="wp_droid_input" id="wp_droid_announcement_description" name="announcement-description" rows="3" cols="60" placeholder="Enter announcement description" maxlenth="1000" class="notification-text-area-field"></textarea>
										<p class="notification-field-description"><strong>Example: </strong>
											<?php print_r(get_bloginfo()); ?> wishing you a very happy and prosperous happy new year</p>
									</td>
								</tr>

								<tr>
									<th class="wp_droid_th">Announcement URL</th>
									<td> <input class="wp_droid_input" id="wp_droid_announcement_url" type="text" name="announcement-url" placeholder="Enter announcement url including http/https" size="60" maxlength="1000">
										<p class="notification-field-description">URL will open in built-in app browser. If Left empty, your application will open</p>
									</td>
								</tr>

								<tr>
									<th class="wp_droid_th">Announcement Image (Optional)</th>
									<td>


										<?php
if (isset($_POST['submit_image_selector']) && isset($_POST['image_attachment_id'])) :
        update_option('media_selector_attachment_id_announcement', absint($_POST['announcement-image']));
    endif;
    wp_enqueue_media(); ?>

											<form method='post'>
												<div class='image-preview-wrapper'>
													<img id='image-preview-announcement' src='<?php echo wp_get_attachment_url(get_option(' media_selector_attachment_id_announcement ')); ?>' style="widht:70%;height:auto;">
												</div>
												<input id="upload_image_button_announcement" type="button" class="button" value="<?php _e('Upload image'); ?>" />
											</form>
											<?php
$my_saved_attachment_post_id_announcement = get_option('media_selector_attachment_id_announcement', 0); ?>
												<script type='text/javascript'>
													jQuery(document).ready(function($) {
														// Uploading files
														var file_frame_announcement;
														var wp_media_post_id_announcement = wp.media.model.settings.post.id; // Store the old id
														var set_to_post_id_announcement = <?php echo $my_saved_attachment_post_id_announcement; ?>; // Set this
														jQuery('#upload_image_button_announcement').on('click', function(event) {
															event.preventDefault();
															// If the media frame already exists, reopen it.
															if (file_frame_announcement) {
																// Set the post ID to what we want
																file_frame_announcement.uploader.uploader.param('post_id', set_to_post_id_announcement);
																// Open frame
																file_frame_announcement.open();
																return;
															} else {
																// Set the wp.media post id so the uploader grabs the ID we want when initialised
																wp.media.model.settings.post.id = set_to_post_id_announcement;
															}
															// Create the media frame.
															file_frame_announcement = wp.media.frames.file_frame_announcement = wp.media({
																title: 'Select announcement image',
																button: {
																	text: 'Use this image',
																},
																multiple: false // Set to true to allow multiple files to be selected
															});
															// When an image is selected, run a callback.
															file_frame_announcement.on('select', function() {
																// We set multiple to false so only get one image from the uploader
																attachment = file_frame_announcement.state().get('selection').first().toJSON();
																// Do something with attachment.id and/or attachment.url here
																$('#image-preview-announcement').attr('src', attachment.url).css({
																	"max-width": "300px",
																	"height": "auto"
																});
																$('#announcement-image').val(attachment.url);

																// Restore the main post ID
																wp.media.model.settings.post.id = wp_media_post_id_announcement;
															});
															// Finally, open the modal
															file_frame_announcement.open();
														});
														// Restore the main ID when the add media button is pressed
														jQuery('a.add_media').on('click', function() {
															wp.media.model.settings.post.id = wp_media_post_id_announcement;
														});
													});
												</script>

												<input class="wp_droid_input" type='hidden' size="60" name='announcement-image' id='announcement-image'>
												<p class="notification-field-description">Leave empty if you want to send "Small Notification". If image is selected, "Big Picture Notification" will be sent.</p>
									</td>
								</tr>

								<tr>
									<td></td>
									<th class="wp_droid_th">
										<button name="wp--droid-notifications-update" type="submit" class="wp_droid_button">Send Announcement</button>
									</th>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- Announcement -->


					<div class="update notification-type">
						<table class="form-table">
							<tbody>
								<tr>
									<th class="wp_droid_th">Latest Version Code</th>
									<td> <input class="wp_droid_input" type="text" name="<?php print_r(INPUT_LATEST_VERSION_CODE)?>" placeholder="Enter Version Code" maxlength="50" size="60" value="<?php echo get_option(INPUT_LATEST_VERSION_CODE, '1'); ?>">
										<p class="notification-field-description">Version code should be an integar and must be greater than previous code</p>
									</td>
								</tr>

								<tr>
									<th class="wp_droid_th">Update type</th>
									<td>
										<fieldset>
											<legend class="screen-reader-text">
												<span>Update type</span>
											</legend>
											<label>
														<input type="radio" name="update_type" value="normal_update" checked="checked">
														<span>Normal update</span> - <span class="notification-field-description">Users <strong>can skip</strong> the update and continue using the application</span>
													</label>
											<br>
											<label>
														<input type="radio" name="update_type" value="force_update">
														<span>Force update</span> - <span class="notification-field-description">Users <strong>must update</strong> the application to use the app</span>
													</label>
										</fieldset>
									</td>
								</tr>

								<tr>
									<td></td>
									<th class="wp_droid_th">
										<button name="wp--droid-notifications-update" type="submit" class="wp_droid_button">Send Update Notification</button>
									</th>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- Update -->


					<div class="clear-cache notification-type">
						<!-- <table class="form-table"> -->
						<h2>Clear entire app cache</h2>

						<h4>This is a invisible notification. App user will not see any notification. App will clear the cache without disturbing the user.</h4>

						<p>Only use this option if you made any major changes to your site. Clearing app cache may slow down the app for the initial load.</p>
						<tr>
							<th>
								<button name="wp--droid-notifications-update" type="submit" class="wp_droid_button" name="clearAllCache">Clear All Caches</button>
							</th>
						</tr>

					</div>
					<!-- Clear Cache -->

			</form>

		</div>
		<!-- wrap -->

	</div>
	<!-- leftColumn -->



	<div class="rightColumn">
		<div class="rightColumn promotions-nonsticky">
      <?php include(WP_DROID_PLUGIN_DIR . '/includes/helpers/license-details.php'); ?>
      <?php include(WP_DROID_PLUGIN_DIR . '/includes/helpers/sidebar-common.php'); ?>
		</div>
	</div>

</div>
<!-- columnsContainer -->


<script type="text/javascript">
	jQuery(document).ready(function($) {


			var isNotificationsAllowed = <?php echo get_option('wp_license_droid_pushnotifications', 0); ?>;

			if(!isNotificationsAllowed) {
				$(".wpdroid-notifications-status").addClass("wpdroid_disable");
			}

      jQuery('.wpdroid_disable').click(function() {
        toastr.error('', 'Not available in your package. Please upgrade to unlock more features', {
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "8000",
            "extendedTimeOut": "1000",
          })
      })



	});
</script>


<?php
}

?>
