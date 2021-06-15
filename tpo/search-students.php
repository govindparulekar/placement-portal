<?php
    require_once '../login/session.php';
    $title = "Search Students";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/search-students.css">
</head>
<body>
    <?php include '../common/sidebar.php'?>
    <?php include '../tpo/modal.php'?>
    <section id = "top">
        <div class="container d-flex justify-content-between">
            <div id="name" class="me-3">
                <input type="text" class="form-control" placeholder = "Name">
            </div>
            <div id="roll" class="me-3">
                <input type="text" class="form-control" placeholder = "Roll no.">
            </div>
            
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
            
            <div class= "top-btn" id="search">
                <button type="button"  class="btn" >Search</button>
            </div>
        </div>    
    </section>
    
    <section class="main">
    <div class="container">    
        
            <div class="default-msg-wrapper d-flex justify-content-center">
                <div class="msg">Search by name and branch or roll and branch or just branch</div>
            </div>
            

        
    </div>
    
</section>

        
        
        
        <?php include '../common/scripts.php'?>
        <script src="../js/search-students.js"></script>
    </body>
</html>