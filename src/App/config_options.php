<?php

$config_options = array(
    // ie. chernoffnewman.com
    'production_domains' => array(),

    // ie. staging.chernoffnewman.com
    'staging_domains' => array(),

    // __('your text', {text_domain})
    'text_domain' => 'app_',

    // used for Piklist
    'key_prefix' => 'app_',

    'default_timezone' => 'America/New_York',

    // allow/disallow this site to be in iFrames
    'iframe_buster' => true,

    'required_plugins' => array(
        'piklist/piklist.php' => array(
            'title' => 'Piklist',
            'url' => 'https://downloads.wordpress.org/plugin/piklist.0.9.4.27.zip'
        ),
        'timber-library/timber.php' => array(
            'title' => 'Timber',
            'url' => 'https://downloads.wordpress.org/plugin/timber-library.0.21.8.zip'
        ),
        'wp-migrate-db-pro/wp-migrate-db-pro.php' => array(
            'title' => 'WP Migrate DB Pro',
            'url' => 'https://deliciousbrains.com/?download_file=21&order=wc_order_5560bce6dcb71&email=jonathan.mayhak%40chernoffnewman.com&key=5454df2e3107dfe6d89d2f40522c7fc3'
        ),
        'wp-migrate-db-pro-media-files/wp-migrate-db-pro-media-files.php' => array(
            'title' => 'WP Migrate DB Pro Media Files',
            'url' => 'https://deliciousbrains.com/?download_file=21&order=wc_order_5560bce6dcb71&email=jonathan.mayhak%40chernoffnewman.com&key=5454df2e3107dfe6d89d2f40522c7fc3&addon=2351'
        )
    ),

    // the top black bar when viewing the website and logged into WP
    'always_hide_admin_bar' => false,

    // this is a custom number pad for all traffic
    'require_auth' => false,

    // set the url for this typekit kit
    'typekit_src' => '',

    // set the logo on the login page
    'login_logo_src' => get_template_directory_uri() . '/img/cn-logo.png',

    // social options
    'social' => array(
        'instagram' => array(
            'support_approval_workflow' => true,
            'default_username' => ''
        ),
        'twitter' => array(
            'default_username' => ''
        ),
        'facebook' => array(
            'default_username' => ''
        )
    )
);
