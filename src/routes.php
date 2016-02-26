<?php
// Modeles
include("models/Article.php");
include("models/Auteur.php");
include("models/Commentaire.php");
include("models/Image.php");

// validation
include("validations/Validation.php");
include("validations/AuteurValidation.php");
include("validations/ArticleValidation.php");

//Controlleurs
include("controllers/Controller.php");
include("controllers/ControllerAdmin.php");
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
    $c = new ControllerAdminArticle($this, $request, $response, $args);
    return $c->destroy();
})->setName('admin.article.destroy');




//----------------------
// Images
//----------------------

//view
$app->get('/admin/image/index', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->index();   
})->setName('admin.image.index');

$app->get('/admin/image/index/{article:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->indexarticle();   
})->setName('admin.image.indexarticle');

$app->get('/admin/image/show/{article:[0-9]+}/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->show();
})->setName('admin.image.show');

//add
$app->post('/admin/image/index/{article:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->store();
})->setName('admin.image.store');

//edit
$app->get('/admin/image/edit/{article:[0-9]+}/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->edit();
})->setName('admin.image.edit');

$app->post('/admin/image/edit/{article:[0-9]+}/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->update();
})->setName('admin.image.update');

//destroy
$app->get('/admin/image/destroy/{article:[0-9]+}/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminImage($this, $request, $response, $args);
    return $c->destroy();
})->setName('admin.image.destroy');





//----------------------
// Commentaire
//----------------------

//view
$app->get('/admin/commentaire/index', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->index();   
})->setName('admin.commentaire.index');

$app->get('/admin/commentaire/show/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->show();
})->setName('admin.commentaire.show');

//add
$app->get('/admin/commentaire/create', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->create();
})->setName('admin.commentaire.create');

$app->post('/admin/commentaire/create', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->store();
})->setName('admin.commentaire.store');

//edit
$app->get('/admin/commentaire/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->edit();
})->setName('admin.commentaire.edit');

$app->post('/admin/commentaire/edit/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->update();
})->setName('admin.commentaire.update');

//destroy
$app->get('/admin/commentaire/destroy/{id:[0-9]+}', function ($request, $response, $args) {
    $c = new ControllerAdminCommentaire($this, $request, $response, $args);
    return $c->destroy();
})->setName('admin.commentaire.destroy');


//----------------------
// FRONTOFFICE
//----------------------

//view
$app->get('/index', function ($request, $response, $args) {
    return $this->view->render($this->response, 'front/listerecherche.html');
})->setName('front.article.index');

//view
$app->get('/article/{id:[0-9]+}', function ($request, $response, $args) {
    return $this->view->render($this->response, 'front/article_view.html');
})->setName('front.article.show');

//view
$app->get('/', function ($request, $response, $args) {
    return $this->view->render($this->response, 'front/index.html');
})->setName('front.index');