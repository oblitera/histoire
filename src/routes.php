<?php
// Modeles
include("models/Article.php");
include("models/Auteur.php");
include("models/Commentaire.php");
include("models/Image.php");

//Controlleurs
include("controllers/Controller.php");
include("controllers/ControllerArticle.php");
include("controllers/ControllerAuteur.php");
include("controllers/ControllerCommentaire.php");
include("controllers/ControllerImage.php");


//----------------------
// User
//----------------------

//view
$app->get('/auteur/index', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->index();   
})->setName('auteur.index');

$app->get('/auteur/show/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->show();
})->setName('auteur.show');

//add
$app->get('/auteur/create', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->create();
})->setName('auteur.create');

$app->post('/auteur/create', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->store();
})->setName('auteur.store');

//edit
$app->get('/auteur/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->edit();
})->setName('auteur.edit');

$app->post('/auteur/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->update();
})->setName('auteur.update');

//destroy
$app->get('/auteur/destroy/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->destroy();
})->setName('auteur.destroy');



//----------------------
// Article
//----------------------

//view
$app->get('/article/{id:[0-9]+}[/{titre}]', function ($request, $response, $args) {
    return "getArticle";
})->setName('viewArticle');

//add
$app->get('/article/add', function ($request, $response, $args) {
    $values = array();
    return $this->view->render($response, 'article_add.html', $values);
})->setName('getAddArticle');

$app->post('/article/add', function ($request, $response, $args) {
    $values = array();
    return $this->view->render($response, 'article_add.html', $values);
})->setName('postAddArticle');

//edit
$app->get('/article/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $values = array();
    return $this->view->render($response, 'article_edit.html', $values);
})->setName('getEditArticle');

$app->post('/article/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $values = array();
    return $this->view->render($response, 'article_edit.html', $values);
})->setName('postEditArticle');

//remove
$app->get('/article/remove/{id:[0-9]+}', function ($request, $response, $args) {
    return "getEditArticle";
})->setName('getEditArticle');

