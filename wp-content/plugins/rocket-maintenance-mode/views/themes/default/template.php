<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ( get_option('mmp_seo_meta') !== '' ): ?>
    <meta name="description" content="<?php esc_attr_e(get_option('mmp_seo_meta')) ?>" />
    <?php endif; ?>

    <?php if ( get_option('mmp_favicon') !== '' ): ?>
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_option('mmp_favicon')) ?>">
    <?php endif; ?>

    <title><?php esc_html_e(get_option('mmp_title')) ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo wpmmp_css_url( 'public/bootstrap/css/bootstrap.min.css' ) ?>" rel="stylesheet">

    <link href="<?php echo wpmmp_css_url( 'public/bootstrap/css/bootstrap-theme.min.css' ) ?>" rel="stylesheet">

    <link href="<?php echo plugins_url( 'assets/css/style.css' , __FILE__ ) ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo '<script src="' . includes_url('/js/jquery/jquery.js') . '"></script>'; ?>
    
    



    <script src="<?php echo wpmmp_css_url( 'public/bootstrap/js/bootstrap.min.js' ) ?>"></script>

    <script src="<?php echo plugins_url( 'assets/js/jquery.countdown.min.js' , __FILE__ ) ?>"></script>


    <?php do_action( 'wpmmp_head' ) ?>


    <?php

    if(wpmmp_is_notificationx_really_setup_and_active()){

        echo '<link rel="stylesheet" href="' . NOTIFICATIONX_PUBLIC_URL . 'assets/css/notificationx-public.min.css" type="text/css">';
        echo '<script type="text/javascript" src="' . NOTIFICATIONX_PUBLIC_URL . 'assets/js/Cookies.js"></script>';
        echo '<script type="text/javascript" src="' . NOTIFICATIONX_PUBLIC_URL . 'assets/js/notificationx-public.min.js"></script>';
    }

    ?>
  </head>
  <body>
    <div id="wrapper" class="theme-<?php echo $this->id ?>">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="logo">
              <img src="<?php echo esc_url(get_option('mmp_logo')) ?>" />
            </div>
            <h1><?php esc_html_e(get_option('mmp_headline')) ?></h1>
            <p><?php esc_html_e(get_option('mmp_subheading')) ?></p>
            <div id="content">
              <?php echo  $this->_content( get_option('mmp_message') )  ?>
            </div>
            <?php if ( get_option('mmp_on_off_countdown') === '1' ): ?>
            <?php if ( defined( 'WPMMP_PRO_VERSION_ENABLED' ) ): ?>
            <div id="countdown"></div>
            <?php endif; ?>
            <?php endif; ?>

            <?php if ( get_option('mmp_on_off_progress') === '1' ): ?>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php esc_attr_e(get_option('mmp_set_progress')) ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
        </div>

        <div class="row">
        <?php $this->add_email_form(false) ?>
        <?php $this->add_social_icons() ?>
        </div>
            
      </div>
    </div>

    <script>
      jQuery(function ($) {
        $('#countdown').countdown( '<?php echo $cd_date ?>', function(event) {
            var $this = $(this).html(event.strftime(''
               + '<span>%D</span> days '
               + '<span>%H</span> hr '
               + '<span>%M</span> min '
               + '<span>%S</span> sec'));
        });

        setTimeout(function(){

          $('.progress .bar').each(function() {
              var me = $(this);
              var perc = me.attr("data-percentage");

              var current_perc = 0;

              var progress = setInterval(function() {
                  if (current_perc>=perc) {
                      clearInterval(progress);
                  } else {
                      current_perc +=1;
                      me.css('width', (current_perc)+'%');
                  }

                  me.text((current_perc)+'%');

              }, 50);

          });

        },300);

      });

      
    </script>

    
    <?php do_action( 'wpmmp_footer' ) ?>
  </body>
</html>