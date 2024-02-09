<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my exams</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

    <style>
         #result{
            text-align: center !important;
            width: 100% !important;
            justify-content: center;
            margin: 15px auto !important;
        }
        #bt{
            display: flex;
            justify-content: center;
            margin-top: 5px;
        }

        #alert{
            text-align: center !important;
        }

        #bt2{
            width: 50% !important;
        }
    </style>
</head>

<body>
    <?php require_once '../nav.php'; ?>
    <?php
        if(isset($_SESSION["info"])){
            $username = 'root';
            $password = '';
            $database = new PDO("mysql:host=localhost; dbname=exams;", $username, $password);

            $quizzes = $database->prepare("SELECT * FROM quizzes WHERE tid = :id");
            $quizzes->bindParam("id",$_SESSION["info"]->ID);
            $quizzes->execute();

            foreach($quizzes as $quiz){
                echo"<div id='result' class='shadow-sm p-3 mb-2'>"
                ."<span>".
                'Quiz name: '.$quiz['name'].
                '</span>
                <form method="post">
                    <button id="bt2" type="submit" name="send02" class="btn btn-success mt-3" value="'.$quiz["ID"].'">Go to editor</button>
                </form>

                <form method="post">
                    <button id="bt2" type="submit" name="send03" class="btn btn-warning mt-3" value="'.$quiz["ID"].'">Add more questions</button>
                 </form>
            </div>
            ';
            }

        }else{
            echo '<script>window.location.href = "https://192.168.1.12/qmaker/login.php";</script>';
        }

        // add security mesuers here!
        if(isset($_POST["send02"])){
            $quizzes2 = $database->prepare("SELECT * FROM quizzes WHERE tid = :id AND ID = :qid3");
            $quizzes2->bindParam("id",$_SESSION["info"]->ID);

            $quizzes2->bindParam("qid3",$_POST["send02"]);

            if(!$quizzes2->execute()){
                echo "error";
            }else{
                $_SESSION["qinfo"] = $quizzes2->fetchObject();
                echo '<script>window.location.href = "https://192.168.1.12/qmaker/teacher/saved.php";</script>';
            }
            
        }

        if(isset($_POST["send03"])){
            $quizzes2 = $database->prepare("SELECT * FROM quizzes WHERE tid = :id AND ID = :qid3");
            $quizzes2->bindParam("id",$_SESSION["info"]->ID);
            
            $quizzes2->bindParam("qid3",$_POST["send03"]);

            if(!$quizzes2->execute()){
                echo "error";
            }else{
                $_SESSION["qinfo"] = $quizzes2->fetchObject();
                echo '<script>window.location.href = "https://192.168.1.12/qmaker/teacher/maker.php";</script>';
            }

            
        }
    ?>
</body>
</html>