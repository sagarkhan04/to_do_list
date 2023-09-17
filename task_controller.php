<?php
include "./config/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? "";
    if ($action == "create_task") {
        $title = $_POST["title"] ?? "";
        $description = $_POST["description"] ?? "";
        $image = $_FILES["image"] ?? "";

        if (!empty($title) && !empty($description) && $image["error"] == 0) {
            $temp_name = $image["tmp_name"];
            $name = md5(time()) . "." . pathinfo($image["name"], PATHINFO_EXTENSION);
            $path = "./assets/img/" . $name;
            $move_file = move_uploaded_file($temp_name, $path);

            $insert_query = "INSERT INTO task (title, description, image) VALUES ('$title', '$description', '$name')";
            $result = mysqli_query($db_connect, $insert_query);

            if ($result) {
                $_SESSION["success"] = "Task created successfully!";
                header("location: index.php");
            } else {
                $_SESSION["error"] = "Failed to create task!";
                header("location: index.php");
            }
        } else {
            $_SESSION["error"] = "Please fill all required fields!";
            header("location: add.php");
        }
    }
    if ($action == "update_task") {
        $id = $_POST["id"] ?? "";
        $title = $_POST["title"] ?? "";
        $description = $_POST["description"] ?? "";
        $image = $_FILES["image"] ?? "";

        if (!empty($id) && !empty($title) && !empty($description) && $image["error"] == 0) {
            $temp_name = $image["tmp_name"];
            $name = md5(time()) . "." . pathinfo($image["name"], PATHINFO_EXTENSION);
            $path = "./assets/img/" . $name;
            $move_file = move_uploaded_file($temp_name, $path);

            $update_query = "UPDATE task SET title = '$title', description = '$description', image = '$name' WHERE id = '$id'";
            $update_result = mysqli_query($db_connect, $update_query);

            if ($update_result) {
                $_SESSION["success"] = "Task updated successfully!";
                header("location: index.php");
            } else {
                $_SESSION["error"] = "Failed to update task!";
                header("location: index.php");
            }
        } else {
            $_SESSION["error"] = "Please fill all required fields!";
            header("location: edit.php?edit_id=<?=$id;?>");
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"] ?? "";

    if (!empty($delete_id)) {
        $delete_query = "DELETE FROM task WHERE id = '$delete_id'";
        $delete_result = mysqli_query($db_connect, $delete_query);

        if ($delete_result) {
            $_SESSION["success"] = "Task deleted successfully!";
            header("location: index.php");
        } else {
            $_SESSION["error"] = "Failed to delete task!";
            header("location: index.php");
        }
    } else {
        $_SESSION["error"] = "Task not found!";
        header("location: index.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["status_id"]) && isset($_GET["action"])) {
    $status_id = $_GET["status_id"] ?? "";
    $action = $_GET["action"] ?? "";

    if (!empty($status_id) && !empty($action)) {
        $status_query = "UPDATE task SET is_done = '$action' WHERE id = '$status_id'";
        $status_result = mysqli_query($db_connect, $status_query);

        if ($status_result) {
            $_SESSION["success"] = "Task status changed!";
            header("location: index.php");
        } else {
            $_SESSION["error"] = "Failed to change task status!";
            header("location: index.php");
        }
    } else {
        $_SESSION["error"] = "Task not found!";
        header("location: index.php");
    }
}
?>