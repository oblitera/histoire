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
$app->get('/admin/auteur/index', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->index();   
})->setName('admin.auteur.index');

$app->get('/admin/auteur/show/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->show();
})->setName('admin.auteur.show');

//add
$app->get('/admin/auteur/create', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->create();
})->setName('admin.auteur.create');

$app->post('/admin/auteur/create', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->store();
})->setName('admin.auteur.store');

//edit
$app->get('/admin/auteur/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->edit();
})->setName('admin.auteur.edit');

$app->post('/admin/auteur/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->update();
})->setName('admin.auteur.update');

//destroy
$app->get('/admin/auteur/destroy/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAuteur($this, $request, $response, $args);
    return $c->destroy();
})->setName('admin.auteur.destroy');



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

