<?php

header("Content-Type: application/json");
include "../config/database.php";

$conn = (new Database())->connect();

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);
$id = $_GET['id'] ?? null;

switch($method){

    case 'GET':
        if($id){
            $stmt = $conn->prepare("SELECT * FROM subjects WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            echo json_encode($conn->query("SELECT * FROM subjects")->fetchAll(PDO::FETCH_ASSOC));
        }
    break;

    case 'POST':
        $stmt = $conn->prepare("INSERT INTO subjects (subject_name) VALUES (:name)");
        $stmt->execute(['name'=>$input['subject_name']]);

        echo json_encode(["message"=>"Created"]);
    break;

    case 'PUT':
        $stmt = $conn->prepare("UPDATE subjects SET subject_name=:name WHERE id=:id");
        $stmt->execute([
            'id'=>$id,
            'name'=>$input['subject_name']
        ]);

        echo json_encode(["message"=>"Updated"]);
    break;

    case 'DELETE':
        $stmt = $conn->prepare("DELETE FROM subjects WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        echo json_encode(["message"=>"Deleted"]);
    break;
}