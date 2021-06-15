<?php
    require_once 'session.php';
  
    $title = "New Drives";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/student-main.css">
    <link rel="stylesheet" href="../css/add-drive.css">
    
</head>
<body>
    <?php include '../common/student-sidebar.php'?>
    <section id = "top" class="container d-flex">
            
                <div class="greeting h3">Hi , <span class="ms-2"><?php echo $_SESSION['username']?> !</span></div>
                
             
    </section>
    
    <section class="main">
        <div class="container" id="new-drives-cont">
            <div class="row">
            
            </div>
        </div>
        
        
    </section>

        
        
        <input type="hidden" id="student-id" name="student_id" value= <?php echo $_SESSION['id']?>>
        <input type="hidden" id="username" name="username" value= <?php echo $_SESSION['username']?>>
        <input type="hidden" id="dp_url" name="dp_url" value= <?php echo $_SESSION['dp_url']?>>
        <input type="hidden" id="tpo_id" name="tpo_id" value= <?php echo $_SESSION['tpo_id']?>>
        <input type="hidden" id="branch_id" name="branch_id" value= <?php echo $_SESSION['branch_id']?>>

        <?php include '../common/scripts.php'?>
        <script src="../js/stud-main.js"></script>
        <script src="../js/new-drives.js"></script>
    </body>
</html>