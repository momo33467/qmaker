<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAM SETTINGS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

    <style>
         #alert{
            text-align: center !important;
        }
    </style>
</head>
<body>
    <?php require_once '../nav.php'; ?>
    <?php
        $username = 'root';
        $password = '';
        $database = new PDO("mysql:host=localhost; dbname=exams;", $username, $password);

        if(isset($_SESSION["info"]) && $_SESSION["info"]->role == "Teacher" && isset($_SESSION["qinfo"])){
            function sanitize($value) {
                return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            // you have to do some sequrity things
            echo' 
            <br>
            <main class="container m-auto" style="max-width:760px !important ;">
               <form method="POST" >
                   <label class="form-label" for="">Exam\'s name:</label>
                   <input class="form-control" type="text" value="'.sanitize($_SESSION['qinfo']->name).'" name="ename">
                   
                   <label  class="form-label" for="">passcode:</label>
           
                   <input class="form-control" type="password" name="epass" value="'.sanitize($_SESSION['qinfo']->passcode).'">
                   <label  class="form-label" for="">Number of allowed attempts:</label>
           
                   <input class="form-control" type="number"  value="'.sanitize($_SESSION['qinfo']->NumOfAttempts).'" name="attmpts">
                   <button class=" mt-2 btn btn-success" name="update" type="submit"  value="'.sanitize($_SESSION['qinfo']->ID).'">Update</button>
                   <a href = "https://192.168.1.12/qmaker/teacher/exams_manager.php" class="mt-2 btn btn-dark">Return</a>

               </form>
           </main>';

        }else{
            echo '<script>window.location.href = "https://192.168.1.12/qmaker/login.php";</script>';
        }

        if(isset($_POST["update"])){
            $upadate = $database->prepare("UPDATE quizzes SET name = :nam, passcode = :code, NumOfAttempts = :attemp WHERE ID = :id");
            $upadate->bindParam("nam",$_POST["ename"]);
            $upadate->bindParam("code",$_POST["epass"]);

            $upadate->bindParam("id",$_SESSION["qinfo"]->ID);
            $upadate->bindParam("attemp",$_POST["attmpts"]);

            if(!$upadate->execute()){
                echo 'error';
            }else{
                $up = $database->prepare("SELECT * FROM quizzes WHERE ID = :id");
                $up->bindParam(":id",$_SESSION['qinfo']->ID);

                $up->execute();
                $_SESSION['qinfo'] = $up->fetchObject();
                echo '<script>window.location.href = "https://192.168.1.12/qmaker/teacher/settings.php";</script>';
            }
            
        }
    ?>

</body>

</html>