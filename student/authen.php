<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passcode</title>
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

        if(isset($_SESSION["qid"])or isset($_GET["QID"])){
            echo '<br>';
            
            echo '
                <div class="container mt-4" style="max-width: 350px;">
                <div class="text-center">
                    <img id="img" src="auth.jpg" alt="error" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                </div>
        
                <div class="mt-3">
                    <div>
                        <form action="" method = "post">
                            <p>Passcode:</p>
                            <input required type="password" class="w-100 form-control mb-2" name="passcode">
        
                            </div>
                            <div>
                                <button type = "submit" name = "pass" class="btn btn-secondary w-100">go</button>
                            </div>
        
                        </form>
                </div>
            </div>
            ';

            if(isset($_POST['pass'])){
                $check = $database->prepare("SELECT * FROM quizzes WHERE passcode = :pass AND ID = :id");
                $check->bindParam("pass",$_POST["passcode"]);

                if(!isset($_GET["QID"]))
                    $check->bindParam("id",$_SESSION["qid"]);
                else
                    $check->bindParam("id",$_GET["QID"]);
                
                if($check->execute()){
                    
                    if($check->rowCount()>0){

                        $_SESSION["quizinfo"] = $check->fetchObject();
                        header("location:https://192.168.1.12/qmaker/student/exam.php",true);

                     }else{
                        
                        echo "<br>";
                        echo '<div id="alert" class="alert alert-danger" role="alert">' .
                        htmlspecialchars("wrong passcode!", ENT_QUOTES, 'UTF-8') . 
                    '</div>';
                     }

                }else{

                    echo '<div id="alert" class="alert alert-danger" role="alert">' .
                     htmlspecialchars("An error has occurred!", ENT_QUOTES, 'UTF-8') . 
                 '</div>';
                }

            }
        }else{
            header("location:https://192.168.1.12/qmaker/login.php",true);
        }
     ?>
</body>
</html>