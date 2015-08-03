<?php
/*
Title: Change the emails to be notified with weekly updates on pending images
Setting: app_instagram_settings
*/

piklist('field', array(
    'type' => 'text',
    'field' => 'emails',
    'label' => 'Email Address',
    'description' => '',
    'columns' => 12,
    'add_more' => true,
    'attributes' => array(
        'class' => 'text'
    )
));


