<?php
include "./config/db.php";
$task_query = "SELECT * FROM task";
$task_result = mysqli_query($db_connect, $task_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>To Do App</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
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
                    <h2 class="m-0 p-0">To Do</h2>
                </div>
                <div>
                    <a href="add.php" class="btn btn-primary">Add New</a>
                </div>
            </div>
            <div class="card-body">
                <!--======================== success sms ======================-->
                <?php if (isset($_SESSION["success"])): ?>
                <div class="alert alert-success"><?=$_SESSION["success"];?></div>
                <?php endif; unset($_SESSION["success"]); ?>
                <!--======================== success sms end ======================-->

                <!--======================== error sms ======================-->
                <?php if (isset($_SESSION["error"])): ?>
                <div class="alert alert-danger"><?=$_SESSION["error"];?></div>
                <?php endif; unset($_SESSION["error"]); ?>

                <!--======================== error sms end ======================-->

                <?php if (isset($_SESSION["edit_error"])): ?>
                <div class="alert alert-danger"><?=$_SESSION["edit_error"];?></div>
                <?php endif; unset($_SESSION["edit_error"]); ?>


                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Title</th>
                            <th scope="col" class="text-center">Description</th>
                            <th scope="col" class="text-center">Image</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($task_result->num_rows > 0): ?>

                        <?php $i = 0; ?>

                        <?php foreach ($task_result as $task): ?>
                        <tr>
                            <th scope="row" class="text-center"><?=++$i;?></th>
                            <td><?=$task["title"];?></td>

                            <td><?=$task["description"];?></td>

                            <td><img src="./assets/img/<?=$task["image"];?>" width="70px" height="70px" /></td>

                            <td class="text-center"><span
                                    class="badge <?=$task["is_done"] == "yes" ? "text-bg-success" : "text-bg-warning";?>"><?=$task["is_done"] == "yes" ? "Complete" : "Incomplete";?></span>
                            </td>

                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="task_controller.php?status_id=<?=$task["id"]?>&action=<?=$task["is_done"] == "yes" ? "no" : "yes";?>"
                                        class="btn-sm btn btn-success">Mark as
                                        <?=$task["is_done"] == "yes" ? "Incomplete" : "Complete";?></a>
                                    <a href="edit.php?edit_id=<?=$task["id"]?>" class="btn-sm btn btn-primary">Edit</a>
                                    <a href="task_controller.php?delete_id=<?=$task["id"]?>"
                                        class="btn-sm btn btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <th colspan="6" class="text-center">No task found!</th>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>