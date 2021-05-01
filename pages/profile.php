<?php
    $title = "Add drive";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <?php include '../common/sidebar.php'?>
    <section id = "top">
        <div class="container d-flex flex-wrap justify-content-between">
            
        </div>    
    </section>
    
    <section class="main">
    <div class="container" id="profile-cont">    
        <div class="avatar-wrapper">
            <div class="avatar">
                <img class="img" src="../images/dp/me.jpg" alt="">
            </div>
            <div class="name">Govind Vishwas Parulekar</div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="container" id="general-info">
                    <label for="general-info">General Info:</label>
                    
                    

                </div>
                <div class="container" id="acadamic-info">
                    <label for="general-info">Acadamic Info:</label>
                    
                              
                </div>
            </div>
        </div>
    </div>
    
</section>

        
        <!--Get student_id from view-drive page-->
        <input id="student-id" type="hidden" name="student-id" value = <?php echo $_GET['student_id']?>>
        <?php include '../common/scripts.php'?>
        <script src="../js/profile.js"></script>
    </body>
</html>