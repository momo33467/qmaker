<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exams</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <style>

        input[type="radio"] {
            cursor: pointer;
        }

         body{
            background-color: rgb(240, 235, 248);
        }

        #alert{
            text-align: center !important;
        }

        #cont{
            background-color: white;
            margin-top: 6px !important;
            /* width: 40% !important; */
        }

        #qs{
            border-bottom: red 1px solid;
        }

        #sh{
            text-align: center !important;
            border: solid red 1px;
            width: 50% !important;
            margin: auto;
        }

        #question{
            word-wrap: break-word;
            white-space: pre-wrap;
            margin: 0 !important;
        }
    </style>

</head>
<body>
    
<?php require_once '../nav.php'; ?>

<?php

    $username = 'root';
    $password = '';
    $database = new PDO("mysql:host=localhost; dbname=exams;", $username, $password);

    if(isset($_SESSION["quizinfo"])){

        $quests = $database->prepare("SELECT * FROM questions WHERE qid = :id");
        $quests->bindParam("id",$_SESSION["quizinfo"]->ID);

        $options = $database->prepare("SELECT * FROM options WHERE quiz = :id");
        $options->bindParam("id",$_SESSION["quizinfo"]->ID);

        if($options->execute() && $quests->execute()){

            $x = 0;
            $n = 0;
            $j = 1;

            echo '<br>';
            echo'<div id="sh" class="shadow p-3 mb-1 bg-body rounded"><h4> '.$_SESSION["quizinfo"]->name.'</h4></div>';

            echo '<div class="container" id = "cont">';
                echo '<form method = "post">';

                foreach($quests as $qs){
                    echo'<div id = "qs">';

                        echo '<div style = "color:red;">
                                <p id = "question">'.$j.':'.$qs["text"].'</p>
                                </div>
                            ';
                        $l = 1;
                        for ($i = $x; $i < $x + 4; $i++) {
                            if ($row = $options->fetch(PDO::FETCH_ASSOC)) {

                                if($row["text"] != ""){
                                    
                                    echo '
                                        <div style = "display:flex;">
                                            <input required  style = "margin-right:7px; width:16px;" type="radio" name = "'.$n.'" value = "'.$row["ID"].'">
                                            <p>'.$row["text"].'</p>
                                        </div>
                                    ';
                                }else{
                                    break;
                                }
                                $l++;
                            }
                        
                        }
                        $n++; // this will be used to maintain the names system
                    echo'</div>';
                    echo "<br>";
                    $j ++;
                }

                echo '<input type = "hidden" name = "num" value = "'.$n.'">';
                echo '<div><button type = "submit" class = "btn btn-info mb-2" name = "send">submit</button></div>';
                echo '</form>';
            echo "</div>";
        }else{
            echo '<div id="alert" class="alert alert-danger" role="alert">' .
                htmlspecialchars("An error has occurred!", ENT_QUOTES, 'UTF-8') . 
            '</div>';
        }

        if(isset($_POST["send"])){
            // get all correct IDs  for the quiz
            $coreect = $database->prepare("SELECT ID FROM options WHERE quiz = :id AND iscorrect = 1");
            $coreect->bindParam("id",$_SESSION["quizinfo"]->ID);

            if($coreect->execute()){
                $score = 0;
                $c = 0;
                
                foreach($coreect as $co){

                    if($co["ID"] == $_POST[$c]){
                        
                        $score ++;
                    }
                    
                    $c++;
                }
                // delete number of attempts and instead check if he has a record in this table 
                $grade = $database->prepare("INSERT INTO attempt(student,score,qid,nofqs) VALUES(:stid,:sc,:quid,:nqs)");

                $grade->bindParam("stid",$_SESSION["info"]->ID);
                $grade->bindParam("sc",$score);

                $grade->bindParam("quid",$_SESSION["quizinfo"]->ID);
                $grade->bindParam("nqs",$c);

                if($grade->execute()){
                    echo '<script>window.location.href = "https://192.168.1.12/qmaker/student/scores.php";</script>"';           

                }else{

                    echo '<div id="alert" class="alert alert-danger" role="alert">' .
                        htmlspecialchars("An error has occurred!", ENT_QUOTES, 'UTF-8') . 
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
<script>
     if(screen.width <= 1000){
        var cont = document.getElementById("cont");
        cont.style.width = "90%";
    }else{
        var cont = document.getElementById("cont");
        cont.style.width = "40%";
    }
</script>
</body>
</html>