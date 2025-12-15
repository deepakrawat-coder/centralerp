<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

require_once "Helper.php";
require_once "headers.php";
require_once "connection.php";
require_once "Logger.php";
require_once "RequestHandler.php";
// echo('asdsa');die;
// ----------- Filter All Inputs -----------
$_GET  = filterInput($_GET);
$_POST = filterInput($_POST);
$logger ="";
$method = $_GET["method"] ?? "";
$uniId  = $_GET["uni_id"] ?? "";
$appLogger = new Logger();
// if()
// ----------- Missing Method Handling -----------
// if($_GET['unidata']==='unidata'){
//      $logger->info("Default university list triggered", [
//         "reason"  => "METHOD_OR_UNI_ID_MISSING",
//         "method"  => $method,
//         "uni_id"  => $uniId,
//         "get"     => $_GET,
//         "post"    => $_POST,
//         "ip"      => $_SERVER['REMOTE_ADDR'] ?? null
//     ]);

//     $sql = "SELECT id, university_name, live_url, logo
//             FROM Universities
//             ORDER BY university_name ASC";

//     $stmt = $db->prepare($sql);
//     $stmt->execute();

//     $universities = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     echo json_encode(
//         api_response(
//             true,
//             200,
//             "UNIVERSITY_LIST",
//             "Universities fetched successfully",
//             $universities
//         ),
//         JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
//     );
//     exit;
// }
// if (isset($_GET['unidata']) && $_GET['unidata'] === 'unidata') {
if($method===""||$uniId===""){
    $appLogger->info("Default university list triggered", [
        "reason" => "UNIDATA_FLAG",
        "method" => $method,
        "uni_id" => $uniId,
        "get"    => $_GET,
        "post"   => $_POST,
        "ip"     => $_SERVER['REMOTE_ADDR'] ?? null
    ]);

    $sql = "SELECT Universities.*
            FROM Universities
            ORDER BY ID ASC";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $universities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(
        api_response(
            true,
            200,
            "UNIVERSITY_LIST",
            "Universities fetched successfully",
            $universities
        ),
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}


if ($method === "") {
    echo json_encode(api_response(
        false,
        400,
        "METHOD_REQUIRED",
        "Please provide API method"
    ));
    exit;
}

$handler  = new RequestHandler($db);

try {
    $response = $handler->handle($method, $uniId);

    // echo json_encode(api_response(
    //     true,
    //     200,
    //     "SUCCESS",
    //     "Request processed successfully",
    //     $response
    // ));
//     echo json_encode(api_response(
//     true,
//     200,
//     "SUCCESS",
//     "Request processed successfully",
//     $response
// ));
// print_r($response);
// die;
echo json_encode(api_response(
    true,
    200,
    "SUCCESS",
    "Request processed successfully",
    $response
), JSON_INVALID_UTF8_SUBSTITUTE);
    exit;

} catch (Exception $e) {

    echo json_encode(api_response(
        false,
        500,
        "SERVER_ERROR",
        $e->getMessage()
    ));
    exit;
}
