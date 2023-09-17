<?php
include "./config/db.php";
$edit_id = $_GET["edit_id"] ?? "";
if (!empty($edit_id)) {
    $query = "SELECT * FROM task WHERE id = '$edit_id'";
    $result = mysqli_query($db_connect, $query);
    if ($result->num_rows == 1) {
        $data = mysqli_fetch_assoc($result);
    } else {
        $_SESSION["edit_error"] = "Task not found!";
        header("location: index.php");
    }
} else {
    $_SESSION["edit_error"] = "Task not found!";
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit - To Do App</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <style>
        .vh-100 {
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="align-items-center d-flex justify-content-center vh-100">
        <div class="card w-50">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="m-0 p-0">Edit</h2>
                </div>
                <div>
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION["error"])): ?>
                <div class="alert alert-danger"><?=$_SESSION["error"];?></div>
                <?php endif; unset($_SESSION["error"]); ?>
                <form action="task_controller.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$data["id"];?>"/>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?=$data["title"];?>" id="title" placeholder="Title"/>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="3"><?=$data["description"];?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="image"/>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" name="action" value="update_task">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>