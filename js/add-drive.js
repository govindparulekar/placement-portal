$(function(){
    
    var $select_branch_inp = $('#select-branch select');
    $select_branch_inp.val(0);
    
    var $msg = $(`<div class="default-msg-wrapper d-flex justify-content-center">
                    <div class="msg"></div>
                </div>`);
    var $row = $('section.main .row');

    $select_branch_inp.on('change',()=>{
        let branch_id = $select_branch_inp.val();
        
            driveReadReq(branch_id);
        
        
    });
    function driveReadReq(branch_id){
        console.log(branch_id,tpo_id);
        if (branch_id != 0) {
            $.post('../api/drive/read-by-branch.php',{
                tpo_id: tpo_id,
                branch_id: branch_id
            },data =>{
                
                renderData(data,branch_id);
            })
            .fail(data =>{
                $row.empty();
                $row.append($msg);
                $msg.text('No record found');
            });
        }
        
    }

    //add drive modal shown
    $('#add-drive-modal').on('shown.bs.modal',()=>{
        $( "#drive-starts" ).datepicker();
        $( "#app-ends" ).datepicker();
        console.log($('#submit-btn'));
        let $select_elig_branch = $('#elig-branch');
        let selected_branches = [];
        $('#add-elig-branch-ico').on('click',()=>{
            let $selected_op = $select_elig_branch.find('option:selected');
            let sel_op_val = $selected_op.val();
            if (sel_op_val != 0 && !selected_branches.includes($selected_op.text())) {
                $('#selected-branches').append(`<div data-branch-id= ${sel_op_val} class="d-flex justify-content-between">
                                                    <span class="align-self-center">
                                                        ${$selected_op.text()}
                                                    </span>
                                                    <i  class="fas ps-2 rem-sel-branch fa-times align-self-center"></i>
                                                </div>`);
                selected_branches.push($selected_op.text());
            }
            $('.rem-sel-branch').on('click',(e)=>{
               $target = $(e.target);
               selected_branches.splice(selected_branches.indexOf($target.prev().text()),1);
                $(e.target).parent().remove();
            });
        });
        


        $('#submit-btn').on('click',(e)=>{
           e.preventDefault();
          let company_name = $('#company-name-inp').val();
          let description = $('#description').val();
          let designation = $('#designation').val();
          let ssc_per = $('#ssc_per').val() != "" ? parseInt($('#ssc_per').val()): null;
          let hsc_dip_per = $('#hsc_dip_per').val()!= "" ? parseInt($('#hsc_dip_per').val()): null;
          let cca= $('#cca').val() != "" ? parseInt($('#cca').val()): null;
          let mlk= $('#mlk').val() != "" ? parseInt($('#mlk').val()): null;         
          let fixed_inp= $('#fixed-inp').val() != "" ? parseInt($('#fixed-inp').val()): null;
          let range_inp= $('#range-inp').val() != "" ? parseInt($('#range-inp').val()): null;
          let job_location= $('#job-location').val();
          let drive_starts = $('#drive-starts').val();
          let app_ends = $('#app-ends').val();
          let no_criteria =  0;
          let strict_check = 0;
          let sheet_link = $('#sheet-link').val() == "" ? null : $('#sheet-link').val();
          $('.form-check-input:checked').each(function(){
              if (this.id == 'no-criteria') {
                  no_criteria = 1;
              }
              if (this.id == 'strict-check') {
                   strict_check = 1;
              }
              console.log(this);
          }
          );
          
          let branch = [];
          let sel_op_val = $select_elig_branch.find('option:selected').val();
          $('#selected-branches div').each(function(){
            branch.push(parseInt($(this).attr('data-branch-id')));
          });
          if (branch.length == 0 || $select_elig_branch.find('option:selected').val()!=0) {
              branch.push(parseInt($select_elig_branch.find('option:selected').val()));
          }
          branch = [...new Set(branch)];
          if (branch.length == 1 && branch[0] == 0) {
              branch = [];
          }
          console.log(branch);
          
          if (company_name&&designation&&description&&job_location&&(fixed_inp||range_inp)&&    (branch.length!==0||sel_op_val!=0)&&drive_starts&&app_ends) {
            drive_starts = drive_starts.split('/');
            app_ends = app_ends.split('/');
            drive_starts = `${drive_starts[2]}-${drive_starts[0]}-${drive_starts[1]}`;
            app_ends = `${app_ends[2]}-${app_ends[0]}-${app_ends[1]}`;
            console.log(drive_starts);
            console.log(app_ends);
            if (no_criteria) {
                driveCreateReq(company_name,description,designation,job_location,fixed_inp,range_inp,branch,drive_starts,app_ends,no_criteria,strict_check,sheet_link);
            }
            else if (ssc_per||hsc_dip_per||cca||mlk) {
                driveCreateReq(company_name,description,designation,job_location,fixed_inp,range_inp,branch,drive_starts,app_ends,no_criteria,strict_check,sheet_link,ssc_per,hsc_dip_per,cca,mlk,sheet_link);
            }
            else{
                alert('Check no criteria');
            }
          }
          else{
              alert('Some fields are not filled!');
          }

        });
    });
    $('#add-drive-modal').on('hide.bs.modal',()=>{
        $('#add-elig-branch-ico').off();
        $('#submit-btn').off();
        $('#selected-branches').empty();
        
    });

    function driveCreateReq(company_name,description,designation,job_location,fixed_inp,range_inp,branch,drive_starts,app_ends,no_criteria,strict_check,sheet_link,ssc_per = null,hsc_dip_per=null,cca=null,mlk=null){
        console.log(company_name,designation,description,ssc_per,hsc_dip_per,cca,mlk,strict_check,fixed_inp,range_inp,  no_criteria,drive_starts,app_ends,job_location,branch);
        $.post('../api/drive/create.php',{
            tpo_id: tpo_id,
            company_name: company_name,
            designation: designation,
            description: description,
            package_fixed: fixed_inp,
            package_range:range_inp,
            drive_start_date: drive_starts,
            app_end_date: app_ends,
            job_location: job_location,
            ssc_per: ssc_per,
            hsc_dip_per: hsc_dip_per,
            current_course_agg: cca,
            max_live_kt: mlk,
            strict_checking: strict_check,
            no_criteria:no_criteria,
            branch: branch,
            sheet_link: sheet_link
        },data=>{
            console.log(data);
            $("#add-drive-modal .form-control").val("");
            $('input:checkbox').prop('checked',false);         
            $('#elig-branch').val(0);
            driveReadReq($select_branch_inp.val());
            alert(data.msg);
        })
        .fail(()=>{
            alert('Something went wrong');
        });
    }



    function renderData(data,branch_id){
        
        $row.empty();
        data.records.forEach(drive =>{
            $col_card = createColCard(drive,branch_id);
            $row.append($col_card);
        });

        $view_btn = $('.view-btn');
        $view_btn.on('click',(e)=>{
            
            $target = $(e.target);
            window.location = `view-drive.php?drive_id=${$target.attr('data-drive-id')}&branch_id=${$target.attr('data-branch-id')}`;
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