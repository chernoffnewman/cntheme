<?php
/*
Title:
Description: Settings for various social channels
Setting: app_social_options
*/

?>

<p>Tutorial on generating an access token: <a href="http://jelled.com/instagram/access-token">http://jelled.com/instagram/access-token</a></p>
<p>How to get Instagram User Id: <a href="http://jelled.com/instagram/lookup-user-id#">http://jelled.com/instagram/lookup-user-id#</a></p>
<p>How to get Facebook Access Token: <a href="https://developers.facebook.com/tools/access_token">https://developers.facebook.com/tools/access_token</a></p>
<?php

use App\Model\Facebook;
use App\Model\Instagram;
use App\Model\Twitter;
use App\Model\YouTube;

piklist('field', array(
		'type' => 'text',
		'field' => Instagram::SETTINGS_FIELD_INSTAGRAM_TOKEN,
		'label' => __('Instagram Access Token'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'field' => Instagram::SETTINGS_FIELD_CLIENT_ID,
		'label' => __('Instagram Client Id'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
		'field' => Instagram::SETTINGS_FIELD_CLIENT_SECRET,
		'label' => __('Instagram Client Secret'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
	'field' => Twitter::SETTINGS_FIELD_ACCESS_TOKEN,
		'label' => __('Twitter Access Token'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
	'field' => Twitter::SETTINGS_FIELD_ACCESS_TOKEN_SECRET,
		'label' => __('Twitter Access Token Secret'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
	'field' => Twitter::SETTINGS_FIELD_CONSUMER_KEY,
		'label' => __('Twitter Consumer Key'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist('field', array(
		'type' => 'text',
	'field' => Twitter::SETTINGS_FIELD_CONSUMER_SECRET,
		'label' => __('Twitter Consumer Secret'),
		'columns' => 12,
		'attributes' => array(
			'class' => 'text'
		),
		'position' => 'wrap'
	));

piklist( 'field', array(
	'type'        => 'text',
	'field' => Facebook::SETTINGS_FIELD_APP_ID,
	'label'       => __( 'Facebook App Id' ),
	'columns'     => 12,
	'attributes'  => array(
		'class' => 'text'
	),
	'position'    => 'wrap'
) );

piklist( 'field', array(
	'type'        => 'text',
	'field' => Facebook::SETTINGS_FIELD_SECRET,
	'label'       => __( 'Facebook Secret' ),
	'columns'     => 12,
	'attributes'  => array(
		'class' => 'text'
	),
	'position'    => 'wrap'
) );

piklist( 'field', array(
	'type'        => 'text',
	'field' => Facebook::SETTINGS_FIELD_ACCESS_TOKEN,
	'label' => __('Facebook Access Token'),
	'columns'     => 12,
	'attributes'  => array(
		'class' => 'text'
	),
	'position'    => 'wrap'
) );

piklist ('field', array(
	'type' => 'text',
	'field' => YouTube::SETTINGS_FIELD_API_KEY,
	'label' => 'YouTube API Key',
	'columns' => 12
));
