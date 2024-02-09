<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nav</title>
    <style>
       
        #logo{
            width: 50px;
        }
        #bar{
            width: 100% !important;
            justify-content: center;
        }

    </style>
</head>
<body>
<?php
  session_start();
  if(isset($_SESSION['info'])){
    if($_SESSION['info']->role == "Teacher"){
        echo '<nav id = "navers" class="navbar navbar-expand-lg bg-light ">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
          <img id="logo" src="logo.png" alt="error">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;" id="bar">

              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="https://192.168.1.12/qmaker/regestration.php">sing up</a>
              </li>

              <li class="nav-item">
                <a class="nav-link active" href="https://192.168.1.12/qmaker/login.php">log in</a>
              </li>
          
              <li class="nav-item">
                <a class="nav-link active" href="https://192.168.1.12/qmaker/teacher/tpage.php">home Page</a>
              </li>

              <li class="nav-item">
                <a class="nav-link active" href="https://192.168.1.12/qmaker/teacher/exams_manager.php">exams manager</a>
              </li>
      
            </ul>
          </div>
        </div>
        </nav>';
    }else{
        echo '<nav id = "navers" class="navbar navbar-expand-lg bg-light ">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img id="logo" src="logo.png" alt="error">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
              <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;" id="bar">

                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="https://192.168.1.12/qmaker/regestration.php">sing up</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link active" href="https://192.168.1.12/qmaker/login.php">log in</a>
                </li>
            
                <li class="nav-item">
                  <a class="nav-link active" href="https://192.168.1.12/qmaker/student/stpage.php">home Page</a>
                </li>
        
              </ul>
            </div>
          </div>
          </nav>';
    }

  }else{
      echo '<nav id = "navers" class="navbar navbar-expand-lg bg-light ">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
        <img id="logo" src="logo.png" alt="error">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;" id="bar">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="https://192.168.1.12/qmaker/regestration.php">sing up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="https://192.168.1.12/qmaker/login.php">log in</a>
            </li>
        
            <li class="nav-item">
              <a class="nav-link active" href="#">home Page</a>
            </li>

          </ul>
        </div>
      </div>
      </nav>';
  }
  
    
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>