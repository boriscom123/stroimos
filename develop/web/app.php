<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_STRICT & ~E_NOTICE);
//error_reporting(E_DEPRECATED);
set_time_limit(600);

//use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';

// Enable APC for autoloading to improve performance.
// You should change the ApcClassLoader first argument to a unique prefix
// in order to prevent cache key conflicts with other applications
// also using APC.

//$apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
//$loader->unregister();
//$apcLoader->register(true);


require_once __DIR__ . '/../app/AppKernel.php';
require_once __DIR__ . '/../app/AppCache.php';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

$is_web_connection = false;
if ($is_web_connection) {
    $kernel = new AppKernel('prod', false);
    $application = new Application($kernel);
    $application->setAutoExit(false);

    $input = new ArrayInput(array(
        'command' => 'fos:elastica:populate',
        // (optional) define the value of command arguments
//        'fooArgument' => 'barValue',
        // (optional) pass options to the command
//        '--message-limit' => $messages,
    ));

    // You can use NullOutput() if you don't need the output
    $output = new BufferedOutput();
    $application->run($input, $output);

    // return the output, don't use if you used NullOutput()
    $content = $output->fetch();

    // return new Response(""), if you used NullOutput()
    return new Response($content);
}

//$kernel = new AppCache($kernel);
// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
