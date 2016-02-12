<?php
// Modeles
include("models/Article.php");
include("models/Auteur.php");
include("models/Commentaire.php");
include("models/Image.php");

//Controlleurs
include("controllers/Controller.php");
include("controllers/ControllerAdminArticle.php");
include("controllers/ControllerAdminAuteur.php");
include("controllers/ControllerAdminCommentaire.php");
include("controllers/ControllerAdminImage.php");
include("controllers/ControllerArticle.php");
include("controllers/ControllerAuteur.php");
include("controllers/ControllerCommentaire.php");
include("controllers/ControllerImage.php");




//----------------------
// User
//----------------------

//view
$app->get('/admin/auteur/index', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->index();   
})->setName('admin.auteur.index');

$app->get('/admin/auteur/show/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->show();
})->setName('admin.auteur.show');

//add
$app->get('/admin/auteur/create', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->create();
})->setName('admin.auteur.create');

$app->post('/admin/auteur/create', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->store();
})->setName('admin.auteur.store');

//edit
$app->get('/admin/auteur/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->edit();
})->setName('admin.auteur.edit');

$app->post('/admin/auteur/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->update();
})->setName('admin.auteur.update');

//add
$app->get('/admin/auteur/changemdp/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->editmdp();
})->setName('admin.auteur.editmdp');

$app->post('/admin/auteur/changemdp/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->updatemdp();
})->setName('admin.auteur.updatemdp');

//destroy
$app->get('/admin/auteur/destroy/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->destroy();
})->setName('admin.auteur.destroy');





//----------------------
// Article
//----------------------

//view
$app->get('/admin/article/index', function ($request, $response, $args) {
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->index();   
})->setName('admin.article.index');

$app->get('/admin/article/show/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->show();
})->setName('admin.article.show');

//add
$app->get('/admin/article/create', function ($request, $response, $args) {
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->create();
})->setName('admin.article.create');

$app->post('/admin/article/create', function ($request, $response, $args) {
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->store();
})->setName('admin.article.store');

//edit
$app->get('/admin/article/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->edit();
})->setName('admin.article.edit');

$app->post('/admin/article/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->update();
})->setName('admin.article.update');

//destroy
$app->get('/admin/article/destroy/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminAuteur($this, $request, $response, $args);
    return $c->destroy();
})->setName('admin.article.destroy');