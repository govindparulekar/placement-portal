$(function(){
    var drive_id = $('#drive_id').val();
    var end_drive = false;
    console.log(drive_id);
    $('#end-drive').on('click',()=>{
        alert('Upload excel sheet containing email id and package of placed students or manually provide them.');
        $('#left-cont').html(`
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
                                <div class= "text-center mt-3" id="end-drive-btn">
                                    <button type="button"  class="btn btn-primary">End Drive</button>
                                </div>
                            </div>
                            
                            `);
    });

    $(document).on('click','#end-drive-btn',function(){
       $.post('../api/drive/delete.php',{
           drive_id: drive_id
       },data=>{
           alert(data.msg);
           window.location = 'add-drive.php';
       })
       .fail(()=>{
           alert('Something went wrong');
       });
    });

    $(document).on('click','#upload-btn',function(e){
       //alert();
        $upload_btn = $(e.target);
        var error,file_ext;
        var valid_ext = ['xls','xlsx'];
        var $file_inp = $('#formFile');
        //check if file and branch is selected
        if ( $file_inp.val() == "") {
            error = "Please select file to upload";
            alert(error);
        }
        else{//check if extension is valid
            file_ext = $file_inp.val().split('.').pop();
            if (!valid_ext.includes(file_ext)) {
                alert('Only Excel sheets having .xsl and .xslx extensions are allowd ');
            }
            else{
                $upload_btn.prop('disabled',true);//disable the button
                //grab file and branch id , send request
                var fd = new FormData();
                var file = $file_inp[0].files[0]; //get the file from file input field
                fd.append('file',file);           //append to formdata object   
                fd.append('drive_id',drive_id);
                $.ajax({
                    url: '../api/placed-student/process-sheet.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        $upload_btn.prop('disabled',false);
                        $file_inp.val("");
                        alert(data.msg);
                        end_drive = true;
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            }
        }
       

    });
    let added = [];
    let placed_students = [];
    $(document).on('click','#add-btn',function(){
        let email = $('#email').val();
        let pkg = $('#pkg').val();
        if (email&&pkg) {
            if (!added.includes(email)) {
            $cont = $('#added-placed-students');
            $row = $(`<div class="row placed-student-row"><div class="col-md-4">${email}</div><div class="col-md-2">${pkg} LPA</div><div id="remove" class="col-md-2"><i class="fas fa-times"></i></div></div>`);

            $cont.append($row);
            added.push(email);
            placed_students.push({email:email,package:parseInt(pkg)});
            console.log(placed_students);
            }
        }     
        
    });
    $(document).on('click','#remove',function(){
       // alert();
        $row = $(this).parent();
      
        added.splice(added.indexOf($row.first().text()),1); 
        placed_students.forEach((ps,i)=>{
            console.log(ps.email , $row[0].firstChild.textContent);
            if (ps.email == $row[0].firstChild.textContent) {
                placed_students.splice(i,1);
                console.log(i);
            }
        });
        $row.remove();
        console.log(placed_students);
    });
   $(document).on('click','#submit-ps-btn',function(){
       if (placed_students.length!=0) {
        placed_students.forEach(ps =>{
            console.log(ps.email,ps.package);
            //console.log(ps);
            $.post('../api/placed-student/create.php',{
                email: ps.email,
                package: ps.package,
                drive_id: drive_id
            },data=>{
                console.log(data);
            })
            .fail((data)=>{
                console.log(data)
            });
        });
        alert('Success');
        end_drive = true;
       }
       added = [];
       placed_students = [];
       console.log(added,placed_students);
       $('#added-placed-students').empty();
   });



});