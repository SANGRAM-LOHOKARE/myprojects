<?php
    $server ="localhost";
    $username ="root";
    $password ="";
    $database ="todo_master";

    $conn = mysqli_connect($server,$username,$password,$database);
    if(!$conn){
        die("Connection Failed: ".mysqli_connect_error());
    }

    if(isset($_POST['Add'])){
        $item = $_POST['item'];
        $sql2 = "INSERT INTO `todo`(`name`) VALUES ('$item')";
        if(mysqli_query($conn,$sql2)){
            echo '<center>
            <div class="alert alert-success" role="alert">Item Added Successfully!</div>
            </center>';
        }else{
            echo "Error: ".mysqli_error($conn);
        }
    }

    if(isset($_GET['action'])){
        $itemid = $_GET['item'];
        if($_GET['action']=="done"){
            $sql2 = "UPDATE `todo` SET `status`= 1 WHERE `id`='$itemid'";
        if(mysqli_query($conn,$sql2)){
            echo '<center>
            <div class="alert alert-info" role="alert">Item Marked as Done</div>
            </center>';
        }else{
            echo "Error: ".mysqli_error($conn);
        }
    }elseif($_GET['action']=='delete'){
        $sql3 = "DELETE FROM `todo` WHERE id='$itemid'";
        if(mysqli_query($conn,$sql3)){
            echo '<center>
            <div class="alert alert-danger" role="alert">Item Deleted Successfully!</div>
            </center>';
        }else{
            echo "Error: ".mysqli_error($conn);
        }
    }
    }
?>




<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<style>
    .done{
        text-decoration: line-through;
    }
</style>
<body>
    <main>
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-3"></div>
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p>TO DO List</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                                 <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Add a new task" name="item">
                                </div>
                                <input type="submit" class="btn btn-dark" name="Add" value="Add item">
                            </form>
                            <div class="mt-5 mb-5"></div>
                                <?php
                                    $sql = "SELECT * FROM `todo`";
                                    $result = mysqli_query($conn,$sql);
                                    if(mysqli_num_rows($result)>0){
                                        while($row = mysqli_fetch_assoc($result)){
                                            $done = $row['status'] == 1 ? 'done' : '';
                                            echo'<div class="row mt-4">
                                                <div class="col-sm-12 col-md-1"><h5>'.$row['id'].'</h5></div>
                                                <div class="col-sm-12 col-md-6"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                                                <div class="col-sm-12 col-md-5">
                                                    <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark as Done</a>
                                                    <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                                </div>
                                                </div>';
                                        }
                                    }else{
                                        echo'<center>
                                                <img src="folder.png" width="50px" alt="Empty list"><br><span>Your List is Empty</span>
                                            </center>';
                                    }
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(".alert").fadeTo(1000, 500).slideUp(500, function(){
                $(this).remove();
            });
        });
    </script>
</body>
</html>