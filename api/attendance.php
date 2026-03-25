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
            $stmt = $conn->prepare("SELECT * FROM attendance WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conn->query("
                SELECT 
                    a.id,
                    s.name AS student,
                    sub.subject_name AS subject,
                    a.attendance_date,
                    a.status
                FROM attendance a
                JOIN students s ON a.student_id = s.id
                JOIN subjects sub ON a.subject_id = sub.id
                ORDER BY a.attendance_date DESC
            ");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
    break;

    case 'POST':
        $stmt = $conn->prepare("
            INSERT INTO attendance (student_id, subject_id, attendance_date, status)
            VALUES (:student_id, :subject_id, :attendance_date, :status)
        ");

        $stmt->execute([
            'student_id'=>$input['student_id'],
            'subject_id'=>$input['subject_id'],
            'attendance_date'=>$input['attendance_date'],
            'status'=>$input['status']
        ]);

        echo json_encode(["message"=>"Attendance recorded"]);
    break;

    case 'PUT':
        $stmt = $conn->prepare("
            UPDATE attendance
            SET student_id=:student_id,
                subject_id=:subject_id,
                attendance_date=:attendance_date,
                status=:status
            WHERE id=:id
        ");

        $stmt->execute([
            'id'=>$id,
            'student_id'=>$input['student_id'],
            'subject_id'=>$input['subject_id'],
            'attendance_date'=>$input['attendance_date'],
            'status'=>$input['status']
        ]);

        echo json_encode(["message"=>"Updated"]);
    break;

    case 'DELETE':
        $stmt = $conn->prepare("DELETE FROM attendance WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        echo json_encode(["message"=>"Deleted"]);
    break;
}