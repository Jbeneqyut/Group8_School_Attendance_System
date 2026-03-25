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
            $stmt = $conn->prepare("SELECT * FROM students WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            echo json_encode($conn->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC));
        }
    break;

    case 'POST':
        if(empty($input['name'])){
            echo json_encode(["message"=>"Name required"]);
            break;
        }

        $stmt = $conn->prepare("INSERT INTO students (name,email) VALUES (:name,:email)");
        $stmt->execute([
            'name'=>$input['name'],
            'email'=>$input['email']
        ]);

        echo json_encode(["message"=>"Student created"]);
    break;

    case 'PUT':
        if(!$id){
            echo json_encode(["message"=>"ID required"]);
            break;
        }

        $stmt = $conn->prepare("UPDATE students SET name=:name,email=:email WHERE id=:id");
        $stmt->execute([
            'id'=>$id,
            'name'=>$input['name'],
            'email'=>$input['email']
        ]);

        echo json_encode(["message"=>"Updated"]);
    break;

    case 'DELETE':
        if(!$id){
            echo json_encode(["message"=>"ID required"]);
            break;
        }

        $stmt = $conn->prepare("DELETE FROM students WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        echo json_encode(["message"=>"Deleted"]);
    break;
}