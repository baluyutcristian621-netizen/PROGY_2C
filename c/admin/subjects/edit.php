<?php 
session_start();
    include "../../config/database.php";

//IF USER IS ALREADY LOGGED IN, SEND THEM TO CORRECT DASHBOARD
    if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
    
        header("Location: ../../index.php");
        exit;
        
    }   

    $id = isset($_GET['id']) ? intval($_GET['id']) :0;
    $result = mysqli_query($conn,"SELECT * FROM users
    WHERE   id=$id ='student'");
    $subject = mysqli_fetch_assoc($result);
    if(!$subject){
        die("student not found");

    }
    $message = "";
    if(isset($_POST['update']))
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $units = $_POST['units'];

    if($_POST['subject']== ""){
        $sql = "UPDATE subjects SET
        scode = '$subject_code',
        subject_name ='subject_name',
        units = '$units',

        WHERE id=$id";

    }

    
    if(mysqli_query($conn,$sql)){
        header("location: index.php");
        exit;

    }else{
        $message = "could not update record";
    }

    



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:700px">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2>Edit Student Account</h2>
            <?php if($message != ""){?>
                     <div class="alert alert-danger"><?php echo $message;?></div>
                     <?php }?>
                        <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Student Number</label>
                    <input type="text" name="student_no" class="form-control" value="<?php echo htmlspecialchars($code['subject_code'])?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($subject['subject_name'])?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($subject['units'])?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password <span class="text-muted">(leave blank to keep old password)</span></label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update Student</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>