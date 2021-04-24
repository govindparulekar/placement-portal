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
                <button type="button"  class="btn">Add Drive</button>
            </div>
        </div>    
    </section>
    
    <section class="main">
    <div class="container" id="drives-cont">    
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row card-info" id="company-name">
                            <div class="col-sm-5">Company</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">Google Private Limited</div>
                        </div>
                        <div class="row card-info" id="position">
                            <div class="col-sm-5">Position</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">Software Developer</div>
                        </div>
                        <div class="row card-info">
                            <div class="col-sm-5">Drive Starts</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">2 April 2021</div>
                        </div>
                        <div class="row card-info">
                            <div class="col-sm-5">Application Ends</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">1 April 2021</div>
                        </div>
                        <div class="card-btn-cont mt-3 d-flex flex-wrap justify-content-between">
                            <button class="btn btn-outline-primary">Applied Students:</button>
                            <button class="btn btn-outline-primary">View</button>
                            <button class="btn btn-outline-danger">End</button>
                        </div>
                        
                    </div>
                </div>
            </div>

            
            

            
            
        </div>
        
    </div>
    
</section>

        
        
        
        <?php include '../common/scripts.php'?>
        <script src="../js/add-drive.js"></script>
    </body>
</html>