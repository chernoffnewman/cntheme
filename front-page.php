<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();


Timber::render('front-page.twig', $context);