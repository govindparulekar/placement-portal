<?php
    $title = "Add drive";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/add-drive.css">
</head>
<body>
    <?php include '../common/sidebar.php'?>
    <?php include '../pages/modal.php'?>
    <section id = "top">
        <div class="container d-flex flex-wrap justify-content-between">
            
            <div id="select-branch">
                <select class="form-select" aria-label="Default select example">
                    <option selected value="0">Select Branch</option>
                    <option value="1">Computer Science</option>
                    <option value="4">Civil</option>
                    <option value="3">Mechanical</option>
                    <option value="2">Electrical</option>
                    <option value="5">Electronics and Telecommunication</option>
                </select>
            </div>
            
            <div class= "top-btn" id="add-drive-btn">
                <button type="button"  class="btn" data-bs-toggle = "modal" data-bs-target="#add-drive-modal">Add Drive</button>
            </div>
        </div>    
    </section>
    
    <section class="main">
    <div class="container" id="drives-cont">    
        <div class="row">
            <div class="default-msg-wrapper d-flex justify-content-center">
                <div class="msg">Select branch to view Active Drives</div>
            </div>
            
        </div>
        
    </div>
    
</section>

        
        
        
        <?php include '../common/scripts.php'?>
        <script src="../js/add-drive.js"></script>
    </body>
</html>