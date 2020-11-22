<?php 
use \Ecommerce\PageAdmin;
use \Ecommerce\Model\User;
use \Ecommerce\Model\Category;



$app->get('/admin', function() {
    
    User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("index");

});

$app->get('/admin/login', function() {
    
	$page = new PageAdmin([
		"header" =>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function()
{
	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function()
{
	User::logout();
	header("Location: /admin/login");
	exit;
});

$app->get("/admin/forgot", function()
{
	$year= date("Y");

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot", array(
	 	"ano"=>$year));
});

$app->post("/admin/forgot", function()
{

	var_dump($user = User::getForgot($_POST["email"]));

	header("Location: /admin/forgot/sent");
	exit;

});

$app->get("/admin/forgot/sent", function()
{
	$year= date("Y");

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-sent");
});


$app->get("/admin/forgot/reset", function()
{
	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));

});

$app->post("/admin/forgot/reset", function()
{
	$forgot = User::validForgotDecrypt($_POST["code"]);

	User::setForgotUser($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);;

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, ["cost"=>12]);

	$user->setPassword($password);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset-success");
});

$app->get("/admin/categories", function()
{
	User::verifyLogin();
	$categories= Category::listAll();
	$page = new PageAdmin();

	$page->setTpl("categories", [
		"categories"=> $categories]);
});

 ?>