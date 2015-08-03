<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();

Timber::render('news-single.twig', $context);