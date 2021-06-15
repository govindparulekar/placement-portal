<?php
    require_once '../login/session.php';
    $title = "Register Students";
    //echo $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
</head>
<body>
    <?php include '../common/sidebar.php'?>
    <section id = "top">
        <form enctype = "multipart/form-data" method="post" id = "reg-student-form">
            <div class="container d-flex ">
                
                <div id="select-file">
                    <input class="form-control" type="file" id="formFile">
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
                
                <div class= "top-btn" id="upload-btn">
                    <button type="button"  class="btn">Upload</button>
                </div>
            </div>    
        </form>
    </section>
    
    <section class="main">
        <div class="container" id="reg-students-table-cont">
            <table class="table" style = "background-color: white">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Roll NO</th>
                    <th scope="col">Division</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- JS will load table rows here-->
                    
                </tbody>
            </table>
        </div>
        <div id="align-wrapper-mailbtn">
            <!--Here will be Mail btn-->
        </div>
        
    </section>

        
        
        
        <?php include '../common/scripts.php'?>
        <script src="../js/register-students.js"></script>
    </body>
</html>