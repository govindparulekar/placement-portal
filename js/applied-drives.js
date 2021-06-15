$(function(){
   
    var student_id = $('#student-id').val();
    var dp_url = $('#dp_url').val();
    $('.profile-img img').attr('src', dp_url );
    

    $.post('../api/drive/read-by-applied-students.php',{
        student_id: student_id
    },data=>{
        console.log(data);
        renderData(data);
    })
    .fail(data=>{
        console.log(data);
        alert('You haven\'t applied to any drive yet' );
    });
    
    function renderData(data){
        $row = $('.main .row');
        $row.empty();
        data.records.forEach(drive =>{
            $col_card = createColCard(drive);
            $row.append($col_card);
        });
    
        $view_btn = $('.view-btn');
        $view_btn.on('click',(e)=>{
            
            $target = $(e.target);
            window.location = `view-drive.php?drive_id=${$target.attr('data-drive-id')}`;
        });
    }
    
    function createColCard(drive){
        let $col_card = $(  `<div class="col-lg-6">
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
                                        <div class="card-btn-cont mt-3 d-flex flex-wrap justify-content-center">
                                            <button  data-drive-id = ${drive.drive_id} class="btn btn-outline-primary view-btn">View</button>
                                        </div> 
                                    </div>
                                </div>
                            </div>`
                            );
    
        return $col_card;
    }
});
