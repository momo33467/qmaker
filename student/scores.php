<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my grades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

    <style>
        #sh{
            text-align: center !important;
            border: solid red 1px;
            width: 80% !important;
            margin: auto;
        }

        #alert{
            text-align: center !important;
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

        $results = $database->prepare("SELECT attempt.ID,score,nofqs,name FROM attempt JOIN quizzes ON attempt.qid = quizzes.ID WHERE student = :stid ORDER BY attempt.ID DESC");
        $results->bindParam("stid",$_SESSION["info"]->ID);
        $results->execute();
        
        echo '<br>';
        echo'<div id="sh" class="shadow p-3 mb-1 bg-body rounded"> Welcome'.' '.$_SESSION["info"]->name.'</div>';
       foreach($results as $result){
            echo '
                <div class="container mt-4" style="width: 250px;">
                <div class="text-center">
                    <img id="img" src="A+.jpg" alt="error" class="img-fluid rounded" style="width: 200px; height: 200px;">
                </div>

                <div class="mt-3">
                    <div>
                        Exam:'.sanitize($result["name"]).'
                    </div>
                    <div style="display: flex;">
                        <p>Score:</p>
                        <p>'.$result["score"].'/'.sanitize($result["nofqs"]).'</p>
                    </div>
                </div>
            ';
        }
    }else{
        header("location:https://".$ip."/qmaker/login.php",true);
    }
?>
</body>
</html>