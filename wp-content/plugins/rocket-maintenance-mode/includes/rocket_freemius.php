<?php

if ( ! function_exists( 'oc_fs' ) ) {
    // Create a helper function for easy SDK access.
    function oc_fs() {
        global $oc_fs;

        if ( ! isset( $oc_fs ) ) {
            // Include Freemius SDK.

           require_once dirname(__FILE__) . '/libs/freemius/start.php';

            $oc_fs = fs_dynamic_init( array(
                'id'                  => '6925',
                'slug'                => 'rocket-maintenance-mode',
                'type'                => 'plugin',
                'public_key'          => 'pk_8be1445a49e73d11a613735f248e8',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'wpmmp-settings',
                    'first-path'     => 'admin.php?page=wpmmp-settings',
                    'account'        => false,
                ),
            ) );
        }

        return $oc_fs;
    }

    // Init Freemius.
    oc_fs();
    // Signal that SDK was initiated.
    do_action( 'oc_fs_loaded' );
} 

?>