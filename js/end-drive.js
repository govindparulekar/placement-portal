$(function(){
    
    $('#end-drive').on('click',()=>{
        
    });

    $('#upload-btn').on('click',function(e){
        alert();
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
                fd.append('drive_id',35559958);
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
    $('#add-btn').on('click',function(){
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
        alert();
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
                drive_id: 35559958  
            },data=>{
                console.log(data);
            })
            .fail((data)=>{
                console.log(data)
            });
        });
        alert('Success');
       }
       added = [];
       placed_students = [];
       console.log(added,placed_students);
       $('#added-placed-students').empty();
   });



});