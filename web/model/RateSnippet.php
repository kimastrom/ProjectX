<?php
require_once 'DbHandler.php';
require_once 'AuthHandler.php';

$dbHandler = new DbHandler();
$sqlQuery = "INSERT INTO rating (userId, snippetId, rating) VALUES (?, ?, ?)";

$user_id = $_POST['user_id']; // Should get user_id from cookie or something here
$snippet_id = $_POST['snippet_id'];
$rating = $_POST['rating'];


if ($stmt = $dbHandler->PrepareStatement($sqlQuery)) {
    $stmt->bind_param("iii", $user_id, $snippet_id, $rating);
    if ($stmt->execute()) {
        echo 1; // Echoes '1' if the rating was successfully applied
    } else {
        echo 0; // Echoes '0' if the user has already voted
    }
    $stmt->close();
}