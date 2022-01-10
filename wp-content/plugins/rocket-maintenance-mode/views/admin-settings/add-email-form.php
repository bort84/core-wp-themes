<?php
include WPMMP_PLUGIN_INCLUDE_DIRECTORY . 'libs/MailChimp.php' ;
use \DrewM\MailChimp\MailChimp;
if(isset($_POST['email'])) 
{       
    if ( ! isset( $_POST['email'] ) ) {
        $email = $_POST['email'];
        if ( ! is_email( $email ) ) {
            wp_redirect(site_url()."?error=0");
        }
    }

    if ( ! wp_verify_nonce( $_POST['wpmmp_email_manager_nonce'],
			'wpmmp_email_manager_nonce' ) ) {
                wp_redirect(site_url()."?error=2");
    } else {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $api_key = get_option( 'mmp_mc_api' );
        $list_id = get_option( 'mmp_mc_listid' );
        $MailChimp = new MailChimp($api_key);

        $result = $MailChimp->post("lists/$list_id/members", [
            'email_address' => $email,
            'status'        => 'subscribed',
        ]);
        
        if($result){
           wp_redirect(site_url()."?success=1");
        } else{
            wp_redirect(site_url()."?error=1");
        }
    }
}
?>
<?php if ( get_option('mmp_on_off_subscribe') === '1' ): ?>
	<form method="POST" class="mm-form <?php if ( $center ) echo 'w3-center' ?>">
	<span>
		<input type="email" name="email" class="mm-input" placeholder='<?php esc_attr_e( get_option('mmp_mc_pt') )?>' id="" style="width: 35%; height: 41px; padding: 18px 22px; font-size: 15px; color: #55B; background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 5px;"> <input type="submit" value="<?php esc_attr_e( get_option('mmp_mc_sbt') ) ?>" class="mm-btn" style="background-color: black; border: none; border-radius: 5px; padding: 10px 20px;">
	</span>
	<input type="hidden" value="<?php echo wp_create_nonce('wpmmp_email_manager_nonce') ?>" name="wpmmp_email_manager_nonce" />
    <?php if(isset($_GET['success']) || isset($_GET['error'])) { ?>
        
        <p class="result">
        <?php
        if($_GET['success'] == 1) 
        {
            echo esc_html(__('Email Submitted Successfully')); 
        } else if($_GET['error'] == 0) {
            echo esc_html(__('Invalid Email Address!'));
        } else if($_GET['error'] == 1) {
            echo esc_html(__('Something went wrong!'));
        } else if($_GET['error'] == 2) {
            echo esc_html(__('Invalid Nonce!'));
        }
        ?>
           </p>
    <?php } ?>
        <div class="success-message"></div>
    <div class="error-message"></div>
	<br>
	<br>
	</form>
<?php endif; ?>
<script>
    jQuery(document).ready(function () {
        jQuery('p.result').delay(5000).fadeOut();
    });
</script>