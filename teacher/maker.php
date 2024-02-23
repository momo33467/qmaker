<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>the maker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

    
    <style>
        input[type="radio"] {
            cursor: pointer;
            margin-left: 5px;
        }
        body{
            background-color: rgb(240, 235, 248);
        }
         #alert{
            text-align: center !important;
        }

        .qla{
            color: red;
        }

        #sh{
            text-align: center !important;
            border: solid red 1px;
            width: 50% !important;
            margin: auto;
        }

        #cont{
            background-color: white;
            /* width: 40% !important; */
        }

        .qs{
            width: 90% !important;
        }

        .tex2{
            width: 94% !important;
            max-height: 300px;
            resize: none;
        }
        #add{
            border: none;
            background: none;
            padding: 0;
            font-size: 45px;
        }

        .flexer{
            display: flex;
        }
    </style>
</head>
<body>
    
<!-- الغلابة فورم -->
   
<?php require_once '../nav.php'; ?>

<?php
    if (isset($_SESSION["info"]) && $_SESSION['info']->role == "Teacher"){

        $username = 'root';
        $password = '';
        $database = new PDO("mysql:host=localhost; dbname=exams;", $username, $password);

        if(isset($_POST["name"])){

            $make = $database->prepare("INSERT INTO quizzes(name,tid,passcode) VALUES(:nam,:t,:pass)");
            $make->bindParam('nam',$_POST["name"]);
            $make->bindParam('t',$_SESSION["info"]->ID);
            $make->bindParam('pass',$_POST["passcode"]);
            

            if(!$make->execute()){
                echo '<div id="alert" class="alert alert-danger" role="alert">' .
                     htmlspecialchars("An error has occurred!", ENT_QUOTES, 'UTF-8') . 
                '</div>';
            }

        }
        
        if(!isset($_SESSION["qinfo"]) or $_SESSION["qinfo"] == "none"){
            $qinfo = $database->prepare("SELECT * FROM quizzes WHERE tid = :id ORDER BY ID DESC LIMIT 1");
            $qinfo->bindParam('id', $_SESSION['info']->ID);

            $qinfo->execute();
            $flag = false;
        }else{
            $flag = true;
            $qinfo2 = $_SESSION["qinfo"];
        }
       
            if(!$flag){
                $qinfo2 = $qinfo->fetchObject();
            }

            echo '<br>';
            echo'<div id="sh" class="shadow p-3 mb-1 bg-body rounded"><h4> '.$qinfo2->name.'</h4></div>';

            echo'
             <br>
            <div class="container" id = "cont">
                <form method="post" >
                    <div id="main" style="display: block;">

                      <label class="form-label qla" for="">Question 1:</label>
                      <textarea oninput="autoResize()" class="form-control tex2" id = "tex"  name="q0" rows="1" autocomplete="off"></textarea>

                        <br>
                        <label class="form-label" for="">Option 1:</label>
                        <div class = "flexer">
                            <input class="form-control qs"  type="text" name="n0" placeholder="you can keep some filds empty if you want less options">
                            <input type="radio" name = "r0" value = "r0">
                        </div>
                        <br>

                        <label class="form-label" for="">Option 2:</label>
                        <div class = "flexer">
                            <input class="form-control qs"  type="text" name="n1">
                            <input type="radio" name = "r0" value = "r1">
                        </div>
                        <br>

                        <label class="form-label" for="">Option 3:</label>
                        <div class = "flexer">
                            <input class="form-control qs" type="text" name="n2">
                            <input type="radio" name = "r0" value = "r2">
                        </div>
                        <br>

                        <label class="form-label" for="">Option 4:</label>
                        <div class = "flexer">
                            <input class="form-control qs" type="text" name="n3">
                            <input type="radio" name = "r0" value = "r3">
                        </div>
                        <br>
                    </div>
                    
                    
                    <div>
                        <button class="btn btn-outline-dark" name="send" type="submit">Save</button>
                        <a href = "https://192.168.1.12/qmaker/teacher/saved.php" class="btn btn-outline-info" name="send2" type="submit">editor</a>    
                    </div>
            
                    <input name="ques" id="inp1" value="1" type="hidden">
                    <input name="ans" id="inp2" value="4" type="hidden">
                </form>
            
                <br>
            
                <div><button id = "add">+</button></div>
            
            </div>';


        if(isset($_POST["ques"])){
            
            $qn = 0;
           for($i = 0; $i < $_POST["ans"]; $i++){
 
                 if($i % 4 == 0){
                     $qus = $database->prepare("INSERT INTO questions(text,qid,tid) VALUES(:te,:id,:t)");
                     $qus->bindParam("te",$_POST["q" . $qn]);
                     $qus->bindParam("id",$qinfo2->ID);
                     $qus->bindParam("t",$_SESSION["info"]->ID);

                     $qus->execute();
                     $qn++;
                     
                 }
 
                 $opt = $database->prepare("INSERT INTO options(text,qid2,iscorrect,tid,quiz) VALUES(:te2,:id2,:correct,:t,:id)");
                 $opt->bindParam("te2",$_POST["n" . $i]);
                 $opt->bindParam("t",$_SESSION["info"]->ID);
                 $opt->bindParam("id",$qinfo2->ID);

                 $qid = $database->prepare("SELECT ID FROM questions WHERE qid = :id3 ORDER BY ID DESC LIMIT 1");
                 $qid->bindParam("id3",$qinfo2->ID);
                 $qid->execute();
                 $qid2 = $qid->fetchObject();

                 $opt->bindParam("id2",$qid2->ID);

                 if($_POST["r" . ($qn - 1)] == ("r" . $i)){
                    $valm = 1;
                    $opt->bindParam("correct",$valm);
                 }else{
                    $valm = 0;
                    $opt->bindValue("correct",$valm);
                 }
                 $opt->execute();

           }
           $_SESSION["qinfo"] = $qinfo2;
           echo '<script>window.location.href = "https://192.168.1.12/qmaker/teacher/saved.php";</script>';
 
         }

    }else{
        header("location:https://192.168.1.12/qmaker/login.php",true);
    }
?>

<script>
    var main = document.getElementById("main");

    localStorage.setItem("ansn", 4);
    localStorage.setItem("q",1);
    var addbtn = document.getElementById("add");

    addbtn.onclick = function(){

        var br2 = document.createElement("br")
        main.appendChild(br2);

        var ques =document.createElement("textarea");
        var la = document.createElement("label");
        
        la.classList.add("form-label");
        la.innerHTML = "Question " + (parseInt(localStorage.getItem("q")) + 1) + ":";
        la.classList.add("qla");
        main.appendChild(la);

        ques.name = "q" + String(localStorage.getItem("q"));

        ques.classList.add("tex2");
        ques.classList.add("form-control");
        ques.id = "tex";

        ques.rows = 1;
        
        localStorage.setItem("q", parseInt(localStorage.getItem("q")) + 1)
        
        main.appendChild(ques);
        var br = document.createElement("br");

        main.appendChild(br);
        for(var i = 0; i<4; i++){

            var flexer2 = document.createElement("div");
            flexer2.classList.add("flexer");

            var la2 = document.createElement("label");
            la2.classList.add("form-label");

            la2.innerHTML = "option " + parseInt(i+1) + ":";
            main.appendChild(la2);


            var ans = document.createElement("input");
            ans.name = "n" + String(parseInt(localStorage.getItem("ansn")) + i);

            ans.classList.add("form-control");
            ans.classList.add("qs");

            var radi = document.createElement("input");
            radi.name = "r" + String(parseInt(localStorage.getItem("q")) - 1 );

            radi.value = "r" + String(parseInt(localStorage.getItem("ansn")) + i);
            radi.type = "radio";
            

            flexer2.appendChild(ans);
            br = document.createElement("br");

            flexer2.appendChild(radi);
            main.appendChild(flexer2);
            
            main.appendChild(br);

        }
  
        
        localStorage.setItem("ansn", parseInt(localStorage.getItem("ansn")) + 4);
        document.getElementById("inp1").value =  parseInt(localStorage.getItem("q"));

        document.getElementById("inp2").value =  parseInt(localStorage.getItem("ansn")); // the next item

        var texars = document.querySelectorAll(".tex2");

        texars.forEach(function (texar) {
            texar.style.cssText = `height: ${texar.scrollHeight}px; overflow-y: hidden`;

            texar.addEventListener("input", function () {
                this.style.height = "auto";
                this.style.height = `${this.scrollHeight}px`;
            });
        });
       

    }; 

    var texars = document.querySelectorAll(".tex2");

    texars.forEach(function (texar) {
        texar.style.cssText = `height: ${texar.scrollHeight}px; overflow-y: hidden`;

        texar.addEventListener("input", function () {
            this.style.height = "auto";
            this.style.height = `${this.scrollHeight}px`;
        });
    });

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