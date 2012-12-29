<?php

Autoloader::namespaces(array(
	'Omnivox' => Bundle::path('omnivox')
));

Autoloader::map(array(
    'Api_Base_Controller'   => Bundle::path('omnivox').'controllers/api_base.php',
));