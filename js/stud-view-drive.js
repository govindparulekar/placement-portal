$(function(){
    let drive_id = $('#drive_id').val();
    console.log(drive_id);
    $drive_cont = $('.main .container');
    var student_id = $('#student-id').val();
    var dp_url = $('#dp_url').val();
    $('.profile-img img').attr('src', dp_url );
    
    let drive_data;
    driveReadReq(drive_id);
    checkifapplied(drive_id);

    $(document).on('click','#apply-btn',async function(){
        //console.log(drive_data);
        let sheet_link = drive_data.sheet_link;
        let criteria = drive_data.ssc_per||drive_data.hsc_dip_per||drive_data.current_course_agg||drive_data.max_live_kt ? true : false;
        if (criteria&&drive_data.strict_checking == 1) {
            let r = await checkEligibility();

            console.log(r);
            if(r){
                console.log(drive_id);
                $.post('../api/student/apply.php',{
                    student_id: student_id,
                    drive_id: drive_id
                },data=>{
                    alert(data.msg);
                    changeApplyBtnState();
                    if (sheet_link) {
                        redirect(sheet_link);
                    }
                })
                .fail(()=>{
                    alert('Something went wrong');
                });
                console.log('elig');
                
                //alert('Application sent');

            }
            else{
                alert("You are not eligible for this drive.");
            }
        }
        else if(sheet_link){
            //let res = {'fail':0};
            apply();
            redirect(drive_data.sheet_link);
        }
        else{
            console.log('here');
            apply();
            
        }
    });

    function changeApplyBtnState(){
        $('#apply-btn').text('Applied');
        $('#apply-btn').prop('disabled',true);
    }
    function apply(){
        $.post('../api/student/apply.php',{
            student_id: student_id,
            drive_id: drive_id
        },data=>{
            alert(data.msg);
            changeApplyBtnState();
        
        })
        .fail(()=>{
            alert('Something went wrong');
        });
    }
    function checkifapplied(drive_id){
        $.get('../api/applied-student/check-if-applied.php',{
            drive_id: drive_id,
            student_id: student_id
        },data=>{
            console.log(data);
            if (data.msg == 'Applied') {
                changeApplyBtnState();        
            }
        });
    }

    function redirect(sheet_link){
        alert("Your are being redirected to google excel sheet to fill extra details required by company. Your appliction will be sent to TPO.")
            window.open(sheet_link,'_blank');
            changeApplyBtnState();
            
        
    }

    async function checkEligibility(){
        let isEligible = true;
        let data = await $.post('../api/student/read.php',{
            student_id: student_id
        });

        let student = data.records[0];
            console.log(student);
            console.log(drive_data.ssc_per,student.ssc_per);
            if (drive_data.ssc_per>student.ssc_per) {
                console.log('here');
                isEligible = false;
            }
            else if(drive_data.hsc_dip_per>student.hsc_dip_per){
                console.log('here');
                isEligible = false;
            }
            else if(drive_data.current_course_agg>student.current_course_agg){
                console.log('here');
                isEligible = false;
            }
            else if(drive_data.max_live_kt<student.active_kt && drive_data.max_live_kt != null){
                console.log('here');
                isEligible = false;
            }
        return isEligible;
    }
    function driveReadReq(drive_id){
        $.post('../api/drive/read-by-id.php',{
            drive_id:drive_id
        },data =>{
            renderDriveDetails(data);
        })
        .fail(data=>{
            alert("something went wrong");
        });
    }
    function renderDriveDetails(data){
        console.log(data);
        drive_data = data.records[0];

        $drive_cont.empty();
        $drive_details_html = $(`<div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Company Name</div>
                                        <div class="col-md-9 d-val">${drive_data.company_name}</div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Description</div>
                                        <div class="col-md-9 d-val">
                                            ${drive_data.description}
                                        </div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Designation</div>
                                        <div class="col-md-9 d-val">${drive_data.designation}</div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Package</div>
                                        <div class="col-md-9 d-val">${drive_data.package_fixed || drive_data.package_range} LPA</div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Criteria</div>
                                        <div class="col-md-9 d-val">
                                            <div class="criteria">SSC % (Throughout) : ${(drive_data.ssc_per)||' No criteria'}</div>

                                            <div class="criteria">HSC/Diploma % (Throughout) : ${(drive_data.hsc_dip_per)||'No criteria'}</div>

                                            <div class="criteria">Engg agg % (Throughout) : ${(drive_data.current_course_agg)||'No criteria'}</div>

                                            <div class="criteria">Live KT (Max) : ${(drive_data.max_live_kt)||'No criteria'}</div>
                                        </div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Job Location</div>
                                        <div class="col-md-9 d-val">${drive_data.job_location}</div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Drive Starts</div>
                                        <div class="col-md-9 d-val">${drive_data.drive_start_date}</div>
                                    </div>
                                    <div class="row drive_detail_rows">
                                        <div class="col-md-3 d-name">Application Ends</div>
                                        <div class="col-md-9 d-val">${drive_data.app_end_date}</div>
                                    </div>`);

        $drive_cont.append($drive_details_html);
        $apply_btn = $(`<div class="btn btn-primary" id="apply-btn">Apply</div>`);
        $drive_cont.append($apply_btn);
    }
});