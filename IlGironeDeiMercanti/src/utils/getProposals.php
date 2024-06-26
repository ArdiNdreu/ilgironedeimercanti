<?php
include_once "../authentication/connessione.php";
include_once "../class/Response.php";

if (isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

} else if (isset($_POST["username"])) {
    $username = $_POST["username"];

    $sql = "SELECT user_id FROM users WHERE username = '$username'";
    $user_id = $conn->query($sql)->fetch_assoc()["user_id"];

} else if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

}
if (!$user_id) {
    $res = new Response("451"); // user not found
    echo $res->json();
    return;
}

$sql = "SELECT * FROM proposals WHERE user_id = $user_id";
$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {

    $l = count($data);
    $data[$l]["article_id"] = $row["article_id"];
    $data[$l]["proposal_id"] = $row["proposal_id"];
    $data[$l]["user_id"] = $row["user_id"];
    $data[$l]["created_at"] = $row["created_at"];
    $data[$l]["price"] = $row["price"];
}

$res = new Response("251", $data); // articles found
echo $res->json();