<?php
include_once 'core/request.php';
include_once 'core/router.php';

include_once 'core/jwt.php';
include_once 'lib/endpoints.php';
include_once 'classes/cinput.php';

include_once 'services/user/User.php';
include_once 'services/food-stash/food-stash.php';
include_once 'services/restaurants/restaurants.php';
include_once 'services/customer/Customer.php';


//ALWAYS INCLUDE FOR CORS CONFIGURATION
include_once 'lib/http-config.php';

if (!in_array(cinput::url($_GET['url']), $auth_exception_endpoints)) {
    var_dump($auth_exception_endpoints);
    $jwt = new JWTTokenizer(null);

    $response = $jwt->validateJWT($_SERVER['HTTP_AUTHORIZATION']);
    if (!$response["success"]) {
        echo json_encode(array("success" => false, "error" => $response["error"]));
        exit;
    }
}


$app = new Router();

$app->route(Request::get("user"), function ($req, $params) {
    if ($req) {
        $user = new User();
        $user->userController($params['id']);
    }
});

$app->route(Request::get("users"), function ($req) {
    if ($req) {
        $user = new User();
        $user->usersController();
    }
});

$app->route(Request::get("agent"), function ($req) {
    if ($req) {
        $user = new User();
        $user->getLoggedInUserController();
    }
});

$app->route(Request::post("create"), function ($req, $data) {
    if ($req) {
        $user = new User();
        $user->createUserController($data);
    }
});

$app->route(Request::post("login"), function ($req, $data) {
    if ($req) {
        $user = new User();
        $user->loginController($data);
    }
});

$app->route(Request::get("stash"), function ($req, $params) {
    if ($req) {
        $stash = new FoodStash();
        $stash->foodStashController($params['location']);
    }
});

$app->route(Request::post("entry"), function ($req, $data) {
    if ($req) {
        $stash = new FoodStash();
        $stash->submitEntry($data);
    }
});

$app->route(Request::get("restaurants"), function ($req, $params) {
    if ($req && $params) {
        $list = new Restaurant();
        $list->restaurantsController($params['location']);
    }
});
$app->route(Request::get("restaurant"), function ($req, $params) {
    if ($req && isset($params['name']) && isset($params['id'])) {
        $list = new Restaurant();
        $list->restaurantController($params);
    } else {
        echo json_encode(array("success" => false, "error" => "Not Found"));
    }
});

$app->route(Request::post("customer"), function ($req, $data) {
    if ($req) {
        $customer = new Customer();
        $customer->loginController($data);
    }
});

$app->route(Request::get("verification"), function ($req, $params) {
    if ($req && $params) {
        $customer = new Customer();
        $customer->verifyController($params);
    }
});
