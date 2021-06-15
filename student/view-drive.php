<?php
    require_once 'session.php';
    
    $title = "View Drive";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/student-main.css">
    <link rel="stylesheet" href="../css/view-drive.css">
</head>
<body>
    <?php include '../common/student-sidebar.php'?>
    <section id = "top" class="container d-flex">
            
                <div class="greeting h3">Hi ,  <span class="ms-2"><?php echo $_SESSION['username']?> !</span></div>
                
             
    </section>
    
    <section class="main">
        <div class="container" id="view-drive-cont">    
        
        </div>
        
    
</section>

        
        
    <input type="hidden" id="drive_id" value="<?php echo $_GET['drive_id']?>">
    <input type="hidden" id="student-id" name="student_id" value= <?php echo $_SESSION['id']?>>
    <input type="hidden" id="username" name="username" value= <?php echo $_SESSION['username']?>>
    <input type="hidden" id="dp_url" name="dp_url" value= <?php echo $_SESSION['dp_url']?>>
    <input type="hidden" id="tpo_id" name="tpo_id" value= <?php echo $_SESSION['tpo_id']?>>
    <input type="hidden" id="branch_id" name="branch_id" value= <?php echo $_SESSION['branch_id']?>>
        <?php include '../common/scripts.php'?>
        <script src="../js/stud-main.js"></script>
        <script src="../js/stud-view-drive.js"></script>
        
    </body>
</html>