
<?php

ini_set('display_errors',0);

// Start Benchmark
$init_time = microtime(true); 

// load core classes
include 'core/model.class.php';
include 'core/kitfast.class.php';

// load extra resources.

// load routes file
include 'routes/routes.php';


// instantiate Kompat Object
$app = new KompatNs\Kompat($routes);

// Add Resources
$app->addResources('orm','orm');

// Run the App
$app->run();


// End Benchmark
$final_time = microtime(true);
$benchmark = $final_time - $init_time;

echo '<!-- Tiempo de Karga KitFast '.$benchmark.' Segundos -->';