$(function(){
    var student_id = $('#student-id').val();
    var dp = $('#student-dp').val();
    $.post('../api/student/read.php',{
        student_id: student_id
    },data => {
        console.log(data);
        renderData(data);
    });
    
    function renderData(data){
        $student = data.records[0];
        $('.avatar img').attr('src',$student.dp);

        $general_info_cont = $('#general-info');
        $acadamic_info_cont = $('#acadamic-info');
        $general_info = $(`<div class="row info-row">
                                <div class="col-md-5 ">Name</div>
                                <div class="col-md-7 ">${$student.name}</div>
                            </div>
                            <div class="row info-row">
                                <div class="col-md-5 ">Roll No</div>
                                <div class="col-md-7 ">${$student.roll_no}</div>
                            </div>      
                            <div class="row info-row">
                                <div class="col-md-5 ">Branch</div>
                                <div class="col-md-7 ">${$student.branch}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Division</div>
                                <div class="col-md-7 ">${$student.division}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Email</div>
                                <div class="col-md-7 ">${$student.email}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Contact</div>
                                <div class="col-md-7 ">${$student.contact}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">D.O.B</div>
                                <div class="col-md-7 ">${$student.dob}</div>
                            </div> `);
        
        $acadamic_info = $(`<div class="row info-row">
                                <div class="col-md-5 ">SSC %</div>
                                <div class="col-md-7 ">${$student.ssc_per}</div>
                            </div>
                            <div class="row info-row">
                                <div class="col-md-5 ">HSC/Diploma %</div>
                                <div class="col-md-7 ">${$student.hsc_dip_per}</div>
                            </div>      
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 1</div>
                                <div class="col-md-7 ">${$student.sem1}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 2</div>
                                <div class="col-md-7 ">${$student.sem2}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 3</div>
                                <div class="col-md-7 ">${$student.sem5}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 4</div>
                                <div class="col-md-7 ">${$student.sem4}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 5</div>
                                <div class="col-md-7 ">${$student.sem5}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 6</div>
                                <div class="col-md-7 ">${$student.sem6}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 7</div>
                                <div class="col-md-7 ">${$student.sem7}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Semister 8</div>
                                <div class="col-md-7 ">${$student.sem8}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Current Course Agg</div>
                                <div class="col-md-7 ">${$student.current_course_agg}</div>
                            </div> 
                            <div class="row info-row">
                                <div class="col-md-5 ">Live KT</div>
                                <div class="col-md-7 ">${$student.active_kt}</div>
                            </div>`);

        $general_info_cont.append($general_info);
        $acadamic_info_cont.append($acadamic_info);
        $('.name').text($student.name);
    }
});