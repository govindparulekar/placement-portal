<?php
    $title = "Add drive";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/view-drive.css">
</head>
<body>
    <?php include '../common/sidebar.php'?>
    <section id = "top">
        <div class="container d-flex flex-wrap justify-content-between">
            
        </div>    
    </section>
    
    <section class="main">
    <div class="container">    
        <div id="main-row" class="row">
            <div id="left-panal" class="col-md-9">
                <div class="container" id="left-cont">
                    
                    
                </div>


            </div>

            <div id="right-panal" class="col-md-3">
                <ul class="list-group">
                    <li id="drive-details" class="list-group-item active">Drive Details</li>
                    <li id="applied-students" class="list-group-item">Applied Students</li>
                    <li id="add-notice" class="list-group-item">Add Notice</li> 
                    <li id="end-drive" class="list-group-item">End Drive</li> 
                </ul>
            </div>
            
        </div>
        
    </div>
    
</section>

        
        
        <input type="hidden" id="drive_id" value="<?php echo $_GET['drive_id']?>">
        <input type="hidden" id="branch_id" value="<?php echo $_GET['branch_id']?>">
        <?php include '../common/scripts.php'?>
        <script src="../js/view-drive.js"></script>
    </body>
</html>