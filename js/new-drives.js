$(function(){
    console.log('hell');
    var branch_id = $('#branch_id').val();
    var tpo_id = $('#tpo_id').val();
    var student_id = $('#student-id').val();

    console.log(tpo_id);
    driveReadReq(branch_id,tpo_id);


    function driveReadReq(branch_id,tpo_id){
        $.post('../api/drive/read-by-branch.php',{
            branch_id: branch_id,
            tpo_id: tpo_id
        },data =>{
            console.log(data);
            renderData(data);
        })
        .fail(data=>{
            alert("No new drives..");
        });
    }

    function renderData(data,branch_id){
        $row = $('.main .row');
        $row.empty();
        data.records.forEach(drive =>{
            $col_card = createColCard(drive,branch_id);
            $row.append($col_card);
        });

        $view_btn = $('.view-btn');
        $view_btn.on('click',(e)=>{
            
            $target = $(e.target);
            window.location = `view-drive.php?drive_id=${$target.attr('data-drive-id')}`;
        });
        
    }
    function createColCard(drive,branch_id){
        
        let $col_card = $(
            `<div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row card-info" id="company-name">
                            <div class="col-sm-5">Company</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">${drive.company_name}</div>
                        </div>
                        <div class="row card-info" id="position">
                            <div class="col-sm-5">Position</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">${drive.designation}</div>
                        </div>
                        <div class="row card-info">
                            <div class="col-sm-5">Drive Starts</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">${drive.drive_start_date}</div>
                        </div>
                        <div class="row card-info">
                            <div class="col-sm-5">Application Ends</div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-6">${drive.app_end_date}</div>
                        </div>
                        <div class="card-btn-cont mt-3 d-flex flex-wrap justify-content-around">
                            <button data-branch-id = ${branch_id} data-drive-id = ${drive.drive_id} class="btn btn-outline-primary view-btn">View</button>

                        </div> 
                    </div>
                </div>
            </div>`
        );

        return $col_card;
    }
});