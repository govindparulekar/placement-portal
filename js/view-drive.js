$(function(){
    //console.log($('#drive_id').val(),$('#branch_id').val());
    var drive_id = $('#drive_id').val();
    var branch_id = $('#branch_id').val();

    var $left_cont = $('#left-cont');
    $('#right-panal li').each(function(){
        console.log($(this));
        $(this).attr('data-drive-id',drive_id);
        $(this).attr('data-branch-id',branch_id);
    });
 
    driveReadReq($('#drive-details').attr('data-drive-id'));
    //Delegating click event to right panal's ul
    $('#right-panal ul').on('click',(e)=>{
        let $clicked_tab = $(e.target);
        let drive_id = $clicked_tab.attr('data-drive-id');
        let branch_id = $clicked_tab.attr('data-branch-id');
        
        //if the clicked tab doesnot have active class get the tab that has active tab, remove active from it and add active to clicked tab
        if (!$clicked_tab.hasClass('active')) {
            $('#right-panal li.active').removeClass('active');
            $clicked_tab.addClass('active');
        }
       
        switch (e.target.id) {
            case 'drive-details':
                driveReadReq(drive_id);
                break;
            case 'applied-students':
                $left_cont.html(
                    `<div id="select-applied-students-inp">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="all">All</option>
                            <option value="placed">Already Placed</option> 
                        </select>
                        </div>`
                );
                appliedStudentsReadReq(drive_id,branch_id,'all');
                $select = $('#select-applied-students-inp select');
                $select.on('change',()=> appliedStudentsReadReq(drive_id,branch_id,$select.val()));
                
                break;

            default:
                break;
        }
    });






   function driveReadReq(drive_id){
       $.post('../api/drive/read-by-id.php',{
           drive_id:drive_id
       },data =>{
           renderDriveDetails(data);
       })
       .fail(data=>{
           alert(data.msg);
       });
   }

    function appliedStudentsReadReq(drive_id,branch_id,q){
        console.log(drive_id,branch_id);
        $.get('../api/applied-student/read.php',{
            drive_id:drive_id,
            branch_id:branch_id,
            q:q
        },data =>{
            console.log(data);
            renderAppliedStudents(data,q);
        })
        .fail(data=>{
            $('#table-cont').remove();
            $('#btn-cont').remove();
            alert('No record found');
        });
    }
    function renderAppliedStudents(data,q){
       
        $('#table-cont').remove();
        $('#btn-cont').remove();

        let records = data.records;      
        $table = $(`<div id="table-cont">
                        <table class="table" style = "background-color: white">
                            <thead>
                                
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>`);
        $left_cont.append($table);
        if (q == 'all') {
            $head_rows = $(`<tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Roll NO</th>
                                <th scope="col"></th>
                            </tr>`);
        }
        else{
            $head_rows = $(`<tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Roll NO</th>
                                <th scope="col">Package</th>
                                <th scope="col"></th>
                            </tr>`);
        }
        $('thead').append($head_rows);
        let i = 1;
        records.forEach(student =>{
            $tr = $('<tr>');
            $tr.append($(`<th scope = "row">${i++}</th>`));
            for (const prop in student) {
                if (prop !== 'student_id') {
                    $tr.append(`<td>${student[prop]}</td>`);
                }
            }
            $op_td = $(`<td>
                            <i data-student-id = ${student.student_id} id="view-icon" class="fas fa-eye op-icon"></i>
                            <i data-student-id = ${student.student_id} id="reject-icon" class="fas fa-minus-circle op-icon"></i>
                            <input data-student-id = ${student.student_id} class="check-box" type="checkbox">
                        </td>`);
            $tr.append($op_td);
            $('tbody').append($tr);
            
        });
        $btn_cont = $(`<div id="btn-cont" class=" d-flex justify-content-between mt-1">
                                <button id = "export" class="btn btn-primary">Export</button>
                                <button id= "reject" class="btn btn-danger">Reject</button>
                            </div>`);
        $left_cont.append($btn_cont);
        $btn_cont = $('#btn-cont');
                console.log($btn_cont);
                $btn_cont.on('click',(e)=>{
                    //alert('reject');
                    $target = $(e.target);
                    switch (e.target.id) {
                        case 'export':
                            
                            break;
                        case 'reject':
                            $checked_boxes = $('input:checked');
                            let student_id_array = [];
                            $checked_boxes.each(function(){
                                student_id_array.push($(this).attr('data-student-id')) 
                            });
                            rejectReq(student_id_array);
                            break;
                        default:
                            break;
                    }
                });
        //show all or already placed applied students depedning on what user selects from dropdown
        
        //view and reject student events
        $('.op-icon').on('click',opIconClickFunc);
    }

    function rejectReq(student_id_array){
       // alert(student_id_array);
        $.post('../api/applied-student/reject.php',{
            student_id_array: student_id_array
        },data =>{
            console.log(data);
            appliedStudentsReadReq(drive_id,branch_id,'all');
            //$('select').val('all');
        })
        .fail(()=> alert('Something went wrong..'));
    }

    

    function opIconClickFunc(e){
        let $target = $(e.target);
        switch (e.target.id) {
            case 'view-icon':
                window.location = `profile.php?student_id=${$target.attr('data-student-id')}`;
                break;
            case 'reject-icon':
                rejectReq([$target.attr('data-student-id')]);
                break;
            default:
                break;
        }
    }

    function renderDriveDetails(data){
       let drive = data.records[0];
    
       $left_cont.empty();
       $drive_details_html = $(`<div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Company Name</div>
                                    <div class="col-md-9 d-val">${drive.company_name}</div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Description</div>
                                    <div class="col-md-9 d-val">
                                        ${drive.description}
                                    </div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Designation</div>
                                    <div class="col-md-9 d-val">${drive.designation}</div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Package</div>
                                    <div class="col-md-9 d-val">${drive.package_fixed || drive.package_range} LPA</div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Criteria</div>
                                    <div class="col-md-9 d-val">
                                        <div class="criteria">SSC % (Throughout) : ${(drive.ssc_per)||' No criteria'}</div>

                                        <div class="criteria">HSC/Diploma % (Throughout) : ${(drive.hsc_dip_per)||'No criteria'}</div>

                                        <div class="criteria">Engg agg % (Throughout) : ${(drive.current_course_agg)||'No criteria'}</div>

                                        <div class="criteria">Live KT (Max) : ${(drive.max_live_kt)||'No criteria'}</div>
                                    </div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Job Location</div>
                                    <div class="col-md-9 d-val">${drive.job_location}</div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Drive Starts</div>
                                    <div class="col-md-9 d-val">${drive.drive_start_date}</div>
                                </div>
                                <div class="row drive_detail_rows">
                                    <div class="col-md-3 d-name">Application Ends</div>
                                    <div class="col-md-9 d-val">${drive.app_end_date}</div>
                                </div>`);

        $left_cont.append($drive_details_html);
   }

});