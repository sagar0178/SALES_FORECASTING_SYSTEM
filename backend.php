<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$response = array(
    'status' => 'success',
    'data' => $data
);

echo json_encode($response);