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
        if(isset($_SESSION["qid"])){
            echo '<br>';
            
            echo '
                <div class="container mt-4" style="max-width: 350px;">
                <div class="text-center">
                    <img id="img" src="auth.jpg" alt="error" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                </div>
        
                <div class="mt-3">
                    <div>
                        <form action="">
                            <p>Passcode:</p>
                            <input type="password" class="w-100 form-control mb-2" name="passcode">
        
                            </div>
                            <div>
                                <button class="btn btn-secondary w-100">go</button>
                            </div>
        
                        </form>
                </div>
            </div>
            ';
        }else{
            header("location:https://192.168.1.12/qmaker/login.php",true);
        }
     ?>
</body>
</html>