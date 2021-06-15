<?php
    $title = "End drive";
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

                   <div id="upload-file">
                        <div class="container d-flex justify-content-between">
                            <div id="select-file">
                                <input class="form-control" type="file" id="formFile">
                            </div>
                            
                            <div class= "top-btn" id="upload-btn">
                                <button type="button"  class="btn">Upload</button>
                            </div>
                        </div>
                        
                   </div>
                   <div class="container" id="enter-data">
                        <div class="row g-3">
                            <div class="col-4">
                                <input type="text" id="email" class="form-control" placeholder="Email" aria-label="Email">
                            </div>
                            <div class="col-4">
                                <input type="text" id="pkg" class="form-control" placeholder="Package e.g 4" aria-label="Package">
                                
                            </div>
                            <div id="add-btn" class="col-4">
                                <i class="fas fa-plus-circle fa-2x"></i>
                            </div>
                        </div>
                        <div id="added-placed-students">
                            
                        </div>
                        <div class= "top-btn" id="submit-ps-btn">
                            <button type="button"  class="btn">Submit</button>
                        </div>
                   </div>

                   <button type="button"  class="btn">End Drive</button>
                    
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
        <script src="../js/end-drive.js"></script>
    </body>
</html>