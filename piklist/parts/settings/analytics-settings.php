<?php
/*
Title:
Description: Settings for various analytics channels
Setting: app_analytics_options
*/


use App\Model\Analytics;
use App\Model\Config;

piklist('field', array(
    'type' => 'radio',
    'field' => Analytics::$field_use_ga,
    'label' => __('Use Google Analytics?', Config::getTextDomain()),
    'value' => Analytics::NO,
    'choices' => Analytics::getYesOrNoOptionsForPiklistSelect()
));

piklist('field', array(
    'type' => 'text',
    'field' => Analytics::$field_ga_code,
    'label' => __('Google Analytics Code', Config::getTextDomain()),
    'conditions' => array(
        array(
            'field' => Analytics::$field_use_ga,
            'value' => Analytics::YES
        )
    )
));

piklist('field', array(
    'type' => 'radio',
    'field' => Analytics::$field_use_crazyegg,
    'label' => __('Use Crazy Egg?', Config::getTextDomain()),
    'value' => Analytics::NO,
    'choices' => Analytics::getYesOrNoOptionsForPiklistSelect()
));
