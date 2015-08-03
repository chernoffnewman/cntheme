<?php

\TimberRoutes::add_route('/login', array('\App\Controller\Auth', 'routeLoginPage'));
\TimberRoutes::add_route('/api/auth', array('\App\Controller\Auth', 'routeLoginAuth'));
