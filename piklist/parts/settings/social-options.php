<?php
/*
Title:
Description: Settings for various social channels
Setting: app_social_options
*/

?>

<p>Tutorial on generating an access token: <a href="http://jelled.com/instagram/access-token">http://jelled.com/instagram/access-token</a></p>
<p>How to get Instagram User Id: <a href="http://jelled.com/instagram/lookup-user-id#">http://jelled.com/instagram/lookup-user-id#</a></p>
<?php

use App\Model\Instagram;

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => Instagram::SETTINGS_FIELD_INSTAGRAM_TOKEN,
		'label' => __('Instagram Token'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => Instagram::SETTINGS_FIELD_USER_ID,
		'label' => __('Instagram User Id'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => Instagram::SETTINGS_FIELD_CLIENT_ID,
		'label' => __('Instagram Client Id'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => Instagram::SETTINGS_FIELD_CLIENT_SECRET,
		'label' => __('Instagram Client Secret'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => 'twitter_access_token',
		'label' => __('Twitter Access Token'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => 'twitter_access_token_secret',
		'label' => __('Twitter Access Token Secret'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => 'twitter_consumer_key',
		'label' => __('Twitter Consumer Key'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => 'twitter_consumer_secret',
		'label' => __('Twitter Consumer Secret'),
//		'description' => __('ex. '),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'scope' => 'post_meta',
		'field' => 'twitter_screen_name',
		'label' => __('Twitter Screen Name'),
		'description' => __('ex. ChernoffNewman'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist( 'field', array(
	'type'        => 'text',
	'scope'       => 'post_meta',
	'field'       => 'facebook_app_id',
	'label'       => __( 'Facebook App Id' ),
	'description' => __( '' ),
	'columns'     => 12,
	'attributes'  => array(
		'class' => 'text'
	),
	'position'    => 'wrap'
) );

piklist( 'field', array(
	'type'        => 'text',
	'scope'       => 'post_meta',
	'field'       => 'facebook_secret',
	'label'       => __( 'Facebook Secret' ),
	'description' => __( '' ),
	'columns'     => 12,
	'attributes'  => array(
		'class' => 'text'
	),
	'position'    => 'wrap'
) );

piklist( 'field', array(
	'type'        => 'text',
	'scope'       => 'post_meta',
	'field'       => 'facebook_user_token',
	'label'       => __( 'Facebook User Token' ),
	'description' => __( '' ),
	'columns'     => 12,
	'attributes'  => array(
		'class' => 'text'
	),
	'position'    => 'wrap'
) );


