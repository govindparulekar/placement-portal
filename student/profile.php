<?php
    require_once 'session.php';
    $title = "My Profile";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../common/head.php'?>
    <link rel="stylesheet" href="../css/profile.css">
    <style>
        .picture{
            width: 150px;
            height: 150px;
            background-color: #999999;
            border: 4px solid #CCCCCC;
            color: #FFFFFF;
            border-radius: 50%;
            margin: 0px auto;
            overflow: hidden;
            transition: all 0.2s;
            -webkit-transition: all 0.2s;
        }
        .picture input[type="file"] {
            cursor: pointer;
            display: block;
           
            
            opacity: 0 !important;
            position: absolute;
            top: 0;
            
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
    <?php include '../common/student-sidebar.php'?>
    <section id = "top">
       
    </section>
    
    
    <section class="main">
    <div class="container" id="profile-cont">    
        <div class="avatar-wrapper">
            <div class="picture">
                <img class="img" src="https://cdn.pixabay.com/photo/2018/11/13/21/43/instagram-3814049_960_720.png" alt="">
                <input type="file" id="profile-pic">
                <h6 class="">Change Profile Pic</h6>
            </div>
            <div class="name"><?php echo $_SESSION['fullname']?></div>
            <div class="uname">Username: <?php echo $_SESSION['username']?></div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="container" id="general-info">
                    <label for="general-info">General Info:</label>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" >
                        </div>
                        <div class="col-md-6">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" >
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" class="form-select">
                                <option selected>select</option>
                                <option value = "male">Male</option>
                                <option value = "female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dob" class="form-label">D.O.B</label>
                            <input type="text" class="form-control" id="dob" >
                        </div>
                    </div>    
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="passout-year" class="form-label">Passout Year</label>
                            <input type="text" class="form-control" id="passout-year">
                        </div>
                        <div class="col-md-6">
                            <label for="inst" class="form-label">Institute</label>
                            <input type="text" class="form-control" id="inst" >
                        </div>
                    </div>
                </div>
                <div class="container" id="academic-info">
                    <label for="academic-info">Acadamic Info:</label>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="ssc-per" class="form-label">SSC Percentage % </label>
                            <input type="number" class="form-control" id="ssc-per">
                        </div>
                        <div class="col-md-6">
                            <label for="hsc-dip-per" class="form-label">HSC/Diploma Percentage % </label>
                            <input type="number" class="form-control" id="hsc-dip-per">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label  class="form-label">SEM 1 </label>
                            <input type="number" class="form-control sem" value = "0">
                        </div>
                        <div class="col-md-6">
                            <label for="hsc-dip-per" class="form-label">SEM 2</label>
                            <input type="number" class="form-control sem" id="hsc-dip-per" value = "0">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="ssc-per" class="form-label">SEM 3</label>
                            <input type="number" class="form-control sem" id="ssc-per" value = "0"> 
                        </div>
                        <div class="col-md-6">
                            <label for="hsc-dip-per" class="form-label">SEM 4</label>
                            <input type="number" class="form-control sem" id="hsc-dip-per" value = "0">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="ssc-per" class="form-label">SEM 5</label>
                            <input type="number" class="form-control sem" id="ssc-per" value = "0">
                        </div>
                        <div class="col-md-6">
                            <label for="hsc-dip-per" class="form-label">SEM 6</label>
                            <input type="number" class="form-control sem" id="hsc-dip-per" value = "0">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="ssc-per" class="form-label">SEM 7</label>
                            <input type="number" class="form-control sem" id="ssc-per" value = "0">
                        </div>
                        <div class="col-md-6">
                            <label for="hsc-dip-per" class="form-label">SEM 8</label>
                            <input type="number" class="form-control sem" id="hsc-dip-per" value = "0">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="cca" class="form-label">Current Course Agg.</label>
                            <input type="number" class="form-control" id="cca">
                        </div>
                        <div class="col-md-6">
                            <label for="active-kt" class="form-label">Active KT</label>
                            <input type="number" class="form-control" id="active-kt">
                        </div>
                    </div>                            
                </div>         
                <div class="save-btn-cont text-center">
                    <button class="btn btn-primary text-center">Save</button>
                </div>    
            </div>
        </div>
    </div>
    
</section>

        
        <input type="hidden" id="student-id" name="student_id" value= <?php echo $_SESSION['id']?>>
        <input type="hidden" id="username" name="username" value= <?php echo $_SESSION['username']?>>
        <input type="hidden" id="name" name="username" value= <?php echo $_SESSION['fullname']?>>
        <input type="hidden" id="dp_url" name="dp_url" value= <?php echo $_SESSION['dp_url']?>>
        <?php include '../common/scripts.php'?>
        <script src="../js/stud-main.js"></script>
        <script src="../js/stud-profile.js"></script>
    </body>
</html>