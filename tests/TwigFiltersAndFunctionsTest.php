<?php

use App\Model\TwigFiltersAndFunctions;

class TwigFiltersAndFunctionsTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        WP_Mock::setUp();
    }

    public function tearDown()
    {
        WP_Mock::tearDown();
    }

    public function testTwitterify()
    {
        $tweet = 'This is a http://chernoffnewman.com test';

        $filtered_tweet = TwigFiltersAndFunctions::twitterify($tweet);

        $this->assertEquals('This is a <a href="http://chernoffnewman.com" target="_blank">http://chernoffnewman.com</a> test', $filtered_tweet);
    }


}
