<?php
if (@$_GET['settings-updated'] == true) {
  wpmmp_empty_cache();
}
?>

<div class='wrap'>
       <?php settings_errors(); ?>

       <form method="post" action="options.php" >
           <?php settings_fields('mmp-settings-group');?>

             <h1>Rocket Maintenance Mode &amp; Coming Soon Page 🚀</h1>

           <br />

            <?php $this->admin_tabs(); ?>

<div id="accordion-1" class="accordion active tab-general-settings">
           <div id="hed3"><h3><?php _e('General Settings')?></h3>
           <span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span></div>
           <br>

<table class="form-table">

         <tr valign='top'>
            <th scope='row'><?php _e('Enable Maintenance Mode ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_on_off" class="onoffswitch-checkbox"  id="myonoffswitch" value='1'<?php checked(1, get_option('mmp_on_off')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    <p>Admin users do not see the maintenance mode page while logged in. Please use an incognito window for testing.</p>
           </td>
          </tr>


       <tr valign='top'>
            <th scope='row'><?php _e(' Enable Progress Bar ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_on_off_progress" class="onoffswitch-checkbox"  id="myonoffswitch8" value='1'<?php checked(1, get_option('mmp_on_off_progress')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch8">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>
          </tr>
          <tr>
        <th scope='row'><?php _e('Set Progress bar %');?></th>
        <td><label for='mmp_set_progress'>
          <input type='range'  id='mmp_set_progress' name='mmp_set_progress' min='0'  max='100' value='<?php echo get_option('mmp_set_progress') ?>' oninput="this.form.amountInputH.value=this.value" /> <input style="width:60px;" type="number"  name="amountInputH" min="0" max="100" value='<?php echo get_option('mmp_set_progress') ?>' size='2' oninput="this.form.mmp_set_progress.value=this.value"  />
          <p class='description'><?php _e('Set Progress bar percentage') ;?></p>
        </label>
        </td>
      </tr>

      <tr valign='top'>
            <th scope='row'><?php _e(' Enable Countdown Timer ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_on_off_countdown" class="onoffswitch-checkbox"  id="myonoffswitch7" value='1'<?php checked(1, get_option('mmp_on_off_countdown')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch7">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>
          </tr>

          <tr>
        <th scope='row'><?php _e('Set Date/Time For Counter');?></th>
        <td><label for='mmp_set_dateTime'>
          <input type='date' id='mmp_set_dateTime' name='mmp_set_dateTime'  value='<?php echo get_option('mmp_set_dateTime' ); ?>' />
          <p class='description'><?php _e('Set Date & time for countdown timer')  ?></p>
        </label>
        </td>
      </tr>
 </table>

</div>

<div id="accordion-2" class="accordion tab-theme-settings">

 <table class="form-table">

            <div id="hed3"><h3><?php _e('Themes')?></h3>
            <span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span>
            </div>
            <div>
            <tr valign='top'>
            <td>
<?php
  wpmmp_pro_themes();
?>
            </td>
            </tr>

         <div>
         </div>
            </table>

</div>

<div id="accordion-3" class="accordion tab-header-settings">
 <table class="form-table">

            <div id="hed3"><h3><?php _e('Header')?></h3><span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span></div>



            <tr valign="top">
        <th scope="row"><?php _e('Favicon'); ?></th>
        <td><label for="mmp_favicon">
          <input id="image_location" type="text" name="mmp_favicon" value="<?php echo get_option('mmp_favicon') ?>" size="50" />
                    <input class="onetarek-upload-button button" type="button" value="Upload Image" />
          <p class='description'><?php _e('Upload or Select Favicon Image, Image must be 16px X 16px.') ;?></p>
         </label>
       </td>
        </tr>

             <tr valign="top">
        <th scope="row"><?php _e('SEO Title'); ?></th>
        <td><label for="mmp_title">
          <input type="text" id="mmp_title"  name="mmp_title" value="<?php echo get_option( 'mmp_title' ); ?>" size="50" />
          <p class="description"><?php _e( 'Enter Title here eg: abcd. '); ?></p>
          </label>
       </td>
        </tr>



        <tr valign="top">
             <th scope="row"><?php _e( 'SEO Meta Description') ?></th>
             <td><label for="mmp_seo_meta">
             <textarea cols="50" rows="2" id="mmp_seo_meta"  name="mmp_seo_meta"  ><?php echo get_option( 'mmp_seo_meta' ); ?> </textarea>
             <p class='description'> <?php _e('Add SEO Meta Description.' );?></p>
          </label>
        </td>
      </tr>






</table>
</div>


<div id="accordion-4" class="accordion tab-email-settings">
 <table class="form-table">

         <div id="hed3"><h3><?php _e('Email Form ')?></h3><span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span></div>
          <tr valign='top'>
            <th scope='row'><?php _e('Show Subscribe Form ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_on_off_subscribe" class="onoffswitch-checkbox"  id="myonoffswitch9" value='1'<?php checked(1, get_option('mmp_on_off_subscribe')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch9">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>

           </td>
          </tr>

      <tr>
        <th scope='row'><?php _e('MailChimp API');?></th>
        <td><label for='mmp_fb_page'>
          <input  size="50" type='text' id='mmp_mc_api' name='mmp_mc_api' value='<?php echo get_option('mmp_mc_api' ); ?>' />
          <p class='description'><?php _e('Enter MailChimp <a href="http://kb.mailchimp.com/accounts/management/about-api-keys" target="_blank">API key</a>') ;?></p>
        </label>
        </td>
      </tr>



      <tr>
        <th scope='row'><?php _e('MailChimp List Id');?></th>
        <td><label for='mmp_mc_listid'>
          <input size="50" type='text' id='mmp_mc_listid' name='mmp_mc_listid' value='<?php echo get_option('mmp_mc_listid' ); ?>' />
          <p class='description'><?php _e('Find your list id : <a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id" target="_blank">here</a>') ;?></p>
        </label>
        </td>
      </tr>


      <tr valign='top'>
            <th scope='row'><?php _e('Double Opt-In');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_mc_optin" class="onoffswitch-checkbox"  id="myonoffswitch9" checked value='1'<?php checked(1, get_option('mmp_mc_optin'));?> />
                     <label class="onoffswitch-label" for="myonoffswitch9">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>
          </tr>


          <tr valign="top">
        <th scope="row"><?php _e('Subscribe Button Text'); ?></th>
        <td><label for="mmp_mc_sbt">
          <input type="text" id="mmp_mc_sbt"  name="mmp_mc_sbt" value="<?php echo get_option( 'mmp_mc_sbt' ); ?>" size="50"  />
          <p class="description"><?php _e( 'Enter subscribe button text here eg: subscribe now. '); ?></p>
          </label>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Placeholder Text'); ?></th>
        <td><label for="mmp_mc_pt">
          <input type="text" id="mmp_mc_pt"  name="mmp_mc_pt" value="<?php echo get_option( 'mmp_mc_pt' ); ?>" size="50" />
          <p class="description"><?php _e( 'Enter text for email placeholder '); ?></p>
          </label>
       </td>
        </tr>

    </table>
</div>

<div id="accordion-5" class="accordion tab-page-settings">
<table class="form-table">

            <div id="hed3"><h3><?php _e('Page Settings')?></h3><span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span></div>


             <tr valign="top">
        <th scope="row"><?php _e('Logo'); ?></th>
        <td><label for="mmp_logo">
          <input id="image_location" type="text" name="mmp_logo" value="<?php echo get_option('mmp_logo') ?>" size="50" />
                    <input class="onetarek-upload-button button" type="button" value="Upload Image" />
          <p class='description'><?php _e('Upload or Select Logo Image 184px X 50px') ;?></p>
         </label>
       </td>
        </tr>
        <?php
        if (wpmmp_is_notificationx_really_setup_and_active()) {
            $nx_args = array (
                'post_type'              => array( 'notificationx' ),
                'post_status'            => array( 'publish' ),
                'nopaging'               => true,
                'order'                  => 'ASC',
            );
            $nx_notifications = get_posts( $nx_args );
            $nx_notifications_dd = array();
    
            if(count($nx_notifications)>0){
                foreach($nx_notifications as $nx_notification){
                    $nx_notifications_dd[] = array('val' => $nx_notification->ID, 'label' => strlen($nx_notification->post_title)?$nx_notification->post_title:'NotificationX '.$nx_notification->ID.' (no title)');
                }
            } else {
                $nx_notifications_dd = false;
            }
            ?>
            <tr id="notificationx-settings">
                <th><label for="notificationx_notification">Notifications</label></th>
                <td>
                
                <?php
                if ($nx_notifications_dd) {
                ?>
                <select name="mmp_notificationx_notification" id="mmp_notificationx_notification">
                <option value="-1">none</option>
                <?php
                foreach($nx_notifications_dd as $nx_notification){
                    echo '<option value="' . $nx_notification['val'] . '"' . ( get_option('mmp_notificationx_notification') ==  $nx_notification['val']?'selected':'' ) . '>' . $nx_notification['label'] . '</option>';
                }
                ?>
                
                <option value="all" <?php echo (@$options['notificationx_notification'] == 'all'?'selected':''); ?> >Show all</option>
                </select>
                <?php } else { ?>
                <p><a href="<?php echo admin_url('post-new.php?post_type=notificationx'); ?>">Create your first notification</a></p>
                <?php } ?>
                
                <p class="description">Create, edit and manage notifications on the <a href="<?php echo admin_url('admin.php?page=nx-admin'); ?>">NotificationX page</a>.</p>
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <th><label for="">Notification Bar</label></th>
                
                <td>
                    <div id="mmp_notificationx_support_upsell" class="onoffswitch">
                     <input type="checkbox" name="mmp_notificationx_support" class="onoffswitch-checkbox" id="mmp_notificationx_support" value="1" <?php checked(1, get_option('mmp_notificationx_support')); ?>>
                     <label class="onoffswitch-label" for="mmp_notificationx_support">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>                     
                     </label>                    
                    </div>

                    <p class="description">Add notifications to instantly engage and influence your visitors' actions using social proof.</p>
                    <p class="description">To add notifications <a href="#" class="open-notificationx-upsell">install the free NotificationX plugin</a>. It seamlessly integrates with Rocket Maintenance Mode and offers numerous options.</p>
                </td>
            </tr>        
        <?php } // notificationx not active ?>


        <tr valign="top">
        <th scope="row"><?php _e('Headline'); ?></th>
        <td><label for="mmp_headline">
          <input type="text" id="mmp_headline"  name="mmp_headline" value="<?php echo get_option( 'mmp_headline' ); ?>" size="50" />
          <p class="description"><?php _e( 'Enter Headline here '); ?></p>
          </label>
       </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?php _e('Tagline'); ?></th>
        <td><label for="mmp_subheading">
          <input type="text" id="mmp_subheading"  name="mmp_subheading" value="<?php echo get_option( 'mmp_subheading' ); ?>" size="50" />
          <p class="description"><?php _e( 'Enter Tagline here '); ?></p>
          </label>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Message'); ?></th>
        <td><label for="mmp_message">
          </label>
          <?php

           $settings = array( 'media_buttons' => false, 'mmp_message', 'teeny' => true, 'quicktags' => false );

            $content = get_option('mmp_message');

            wp_editor( $content, 'mmp_message', $settings );

          ?>
       </td>
        </tr>

</table>
</div>

<div id="accordion-6" class="accordion tab-design-settings">
        <table class="form-table">

            <div id="hed3"><h3><?php _e('Design')?></h3><span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span></div>
         <tr>
        <th scope='row'><?php _e('Background Color');?></th>
        <td><label for='mmp_bgcolor'>
          <input type='text' class='color_picker' id='mmp_bgcolor' name='mmp_bgcolor' value='<?php echo get_option('mmp_bgcolor' ); ; ?>'/>
          <p class='description'><?php _e('Change background color') ;?></p>
        </label>
        </td>
      </tr>
      <tr>
        <th scope='row'><?php _e('Headline Color');?></th>
        <td><label for='mmp_headline_color'>
          <input type='text' class='color_picker' id='mmp_headline_color' name='mmp_headingcolor' value='<?php echo get_option('mmp_headingcolor' ); ; ?>'/>
          <p class='description'><?php _e('Change Headline color') ;?></p>
        </label>
        </td>
      </tr>
      <tr>
        <th scope='row'><?php _e('Text Color');?></th>
        <td><label for='mmp_text_color'>
          <input type='color'  id='mmp_text_color' name='mmp_text_color' value='<?php echo get_option('mmp_text_color' ); ?>'/>
          <p class='description'><?php _e('Change Text color') ;?></p>
        </label>
        </td>
      </tr>
      <tr>
        <th scope='row'><?php _e('Links Color');?></th>
        <td><label for='mmp_links_color'>
          <input type='color'  id='mmp_links_color' name='mmp_links_color' value='<?php echo get_option('mmp_links_color' ); ?>' />
          <p class='description'><?php _e('Change Links color') ;?></p>
        </label>
        </td>
      </tr>
      <tr>
        <th scope='row'><?php _e('Links Hover Color');?></th>
        <td><label for='mmp_links_hover_color'>
          <input type='color' id='mmp_links_hover_color' name='mmp_links_hover_color' value='<?php echo get_option('mmp_links_hover_color' ); ?>' />
          <p class='description'><?php _e('Change Links hover color') ;?></p>
        </label>
        </td>
      </tr>
      <th scope='row'><?php _e('Font Family For Text');?></th>
        <td><label for='mmp_fft'>
            <input id="font" type="text" name="mmp_fft" value="<?php echo get_option( 'mmp_fft' ); ?>" />

          </label>
        </td>
      </tr>
      <tr>
        <th scope='row'><?php _e('Font Family For Header Text');?></th>
        <td><label for='mmp_ffht'>
          <input id="font1" name="mmp_ffht" type="text" value="<?php echo get_option( 'mmp_ffht' ); ?>" />

        </label>
        </td>
      </tr>

      <tr valign="top">
             <th scope="row"><?php _e( 'Custom CSS') ?></th>
             <td><label for="mmp_custom_css">
             <textarea cols="80" rows="7" id="mmp_custom_css"  name="mmp_custom_css" ><?php echo get_option( 'mmp_custom_css' ); ?></textarea>
          </label>
        </td>
      </tr>

</table>
</div>
<div id="accordion-8" class="accordion tab-social-settings">
     <table class="form-table">

            <div id="hed3"><h3><?php _e('Social')?></h3><span class="heading_save_btn">
          <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </span></div>
      <tr>
        <th scope='row'><?php _e('Facebook Page Link');?></th>
        <td><label for='mmp_fb_page'>
          <input type='text' id='mmp_fb_page' name='mmp_fb_page' value='<?php echo get_option('mmp_fb_page' ); ?>'/>
          <p class='description'><?php _e('Enter Facebook Link') ;?></p>
        </label>
        </td>
      </tr>

       <tr>
        <th scope='row'><?php _e('Twitter Page Link');?></th>
        <td><label for='mmp_tw_page'>
          <input type='text' id='mmp_tw_page' name='mmp_tw_page' value='<?php echo get_option('mmp_tw_page' ); ?>'/>
          <p class='description'><?php _e('Enter Twitter Link') ;?></p>
        </label>
        </td>
      </tr>

       <tr>
        <th scope='row'><?php _e('LinkedIn Page Link');?></th>
        <td><label for='mmp_lkin_page'>
          <input type='text' id='mmp_lkin_page' name='mmp_lkin_page' value='<?php echo get_option('mmp_lkin_page' ); ?>'/>
          <p class='description'><?php _e('Enter LinkedIn Link') ;?></p>
        </label>
        </td>
      </tr>



      <tr>
        <th scope='row'><?php _e('Pinterest Page Link');?></th>
        <td><label for='mmp_pin_page'>
          <input type='text' id='mmp_pin_page' name='mmp_pin_page' value='<?php echo get_option('mmp_pin_page' ); ?>'/>
          <p class='description'><?php _e('Enter Pinterest Link') ;?></p>
        </label>
        </td>
      </tr>


       <tr>
        <th scope='row'><?php _e('Instagram Page Link');?></th>
        <td><label for='mmp_insta_page'>
          <input type='text' id='mmp_insta_page' name='mmp_insta_page' value='<?php echo get_option('mmp_insta_page' ); ?>'/>
          <p class='description'><?php _e('Enter Instagram Link') ;?></p>
        </label>
        </td>
      </tr>



      <tr valign='top'>
            <th scope='row'><?php _e('Show Facebook Icon ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_show_fb" class="onoffswitch-checkbox"  id="myonoffswitch2" value='1'<?php checked(1, get_option('mmp_show_fb')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch2">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>

          </tr><tr valign='top'>
            <th scope='row'><?php _e('Show Twitter Icon ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_show_tw" class="onoffswitch-checkbox"  id="myonoffswitch3" value='1'<?php checked(1, get_option('mmp_show_tw')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch3">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>

          </tr><tr valign='top'>
            <th scope='row'><?php _e('Show LinkedIn Icon ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_show_lk" class="onoffswitch-checkbox"  id="myonoffswitch4" value='1'<?php checked(1, get_option('mmp_show_lk')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch4">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>
          </tr>


          </tr><tr valign='top'>
            <th scope='row'><?php _e('Show Pinterest Icon ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_show_pin" class="onoffswitch-checkbox"  id="myonoffswitch5" value='1'<?php checked(1, get_option('mmp_show_pin')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch5">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>
          </tr>



          </tr><tr valign='top'>
            <th scope='row'><?php _e('Show Instagram Icon ');?></th>
            <td>
               <div class="onoffswitch">
                     <input type="checkbox" name="mmp_show_insta" class="onoffswitch-checkbox"  id="myonoffswitch6" value='1'<?php checked(1, get_option('mmp_show_insta')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch6">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
           </td>
          </tr>

    </table>
</div>



      <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="button button-secondary big" href="<?php echo get_home_url() ?>?wpmmp-mode=enabled&nonce=<?php echo wp_create_nonce( 'wpmmp-preview-nonce' ); ?>" target="_blank" data-toggle="tooltip" data-placement="right" title="Please Save First!">Preview Page</a>
      </p>

      <div id="notificationx-upsell-dialog" style="display: none;" title="NotificationX"><span class="ui-helper-hidden-accessible"><input type="text"/></span>
      <div style="padding: 20px; font-size: 14px;">
      <ul class="wpmmp-list">
      <li>influence your visitors’ actions using social proof notifications</li>
      <li>increase your leads, sales & engagements</li>
      <li>boost conversion rates using 4 different types of notification</li>
      <li>works out-of-the-box</li>
      <li>free plugin available from the official WordPress repository</li>
      </ul>
      <p class="upsell-footer"><a class="button button-primary" id="install-notificationx">Install &amp; activate NotificationX to display notification bars</a></p>
      </div>
      </div>

   

</form>

<form id="reset" method="post" action="">
  <p class="submit">
  <input name="reset" class="button button-secondary" type="submit" value="Reset to default settings">&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="https://wordpress.org/support/plugin/rocket-maintenance-mode/reviews/#new-post" target="_blank" class="button-secondary button">Like the plugin? Rate it ★★★★★</a>
  <input type="hidden" value="reset" />
  </p>
</form>

</div> <!-- wraper-->
