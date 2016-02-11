<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

// Database information
$settings = array(
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'histoire',
    'username' => 'root',
    'password' => '',
	"charset"   => "utf8",
    "collation" => "utf8_general_ci",
    'prefix' => ''
);

/*-------------------------------*/
// Bootstrap Eloquent ORM
/*-------------------------------*/
$container = new Illuminate\Container\Container;
$connFactory = new \Illuminate\Database\Connectors\ConnectionFactory($container);
$conn = $connFactory->make($settings);
$resolver = new \Illuminate\Database\ConnectionResolver();
$resolver->addConnection('default', $conn);
$resolver->setDefaultConnection('default');
\Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);

/*-------------------------------*/
//on préenregistre quelque variable interresante...
/*-------------------------------*/
$app->add(function ($request, $response, $next) {
    //url utile
    $base_url = "http://".$_SERVER['HTTP_HOST'].$request->getUri()->getBasePath();
    $css_url = $base_url.'/css/';
    $js_url = $base_url.'/js/';
    $theme_admin = $base_url.'/themes/admin/';
    $this->view->offsetSet('baseUrl', $base_url); 
    $this->view->offsetSet('cssUrl', $css_url);
    $this->view->offsetSet('jsUrl', $js_url);
    $this->view->offsetSet('themeAdmin', $theme_admin);

    //message flash
    $this->view->offsetSet('flashErreur', $this->flash->getMessage("error"));
    $this->view->offsetSet('flashSucces', $this->flash->getMessage("success"));

    return $next($request, $response);
});