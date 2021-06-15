$(function(){
   
    var $upload_btn = $('#upload-btn .btn');  
    
    console.log(dp,tpo_id);
    //upload event
    $upload_btn.on('click',(e)=>{
        
        var error,file_ext;
        var valid_ext = ['xls','xlsx'];
        var $file_inp = $('#formFile');
        var $select_inp = $('select'); 
        //check if file and branch is selected
        if (( $file_inp.val() == "" || $select_inp.val() == 0)) {
            error = "Please select file and branch to upload";
            alert(error);
        }
        else{//check if extension is valid
            file_ext = $file_inp.val().split('.').pop();
            if (!valid_ext.includes(file_ext)) {
                alert('Only Excel sheets having .xsl and .xslx extensions are allowd ');
            }
            else{
                $upload_btn.prop('disabled',true);//disable the button
                $upload_btn.text('Uploading..');
                //grab file and branch id , send request
                var fd = new FormData();
                var file = $file_inp[0].files[0]; //get the file from file input field
                var branch_id = $select_inp.val();//get the branch id from select input
                fd.append('file',file);           //append to formdata object   
                fd.append('branch_id',branch_id);
                fd.append('tpo_id',tpo_id);
                $.ajax({
                    url: '../api/student/register.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        $upload_btn.prop('disabled',false);
                        $upload_btn.text('Upload');
                        $file_inp.val("");
                        $select_inp.val(0);
                        alert(data.msg);
                        renderData(data); //construct table showing students details and generate mail button
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            }
        }

    });


    function renderData(data){
        //console.log(data);
        var i = 1;
        var $tbody = $('tbody');
        var $mail_btn = $('<button class="btn btn-primary">Mail</button>');
        $tbody.empty();                                 //empty old displayed data
        data.records.forEach(student => {
            $tr = $('<tr>');
            $th = $(`<th scope ="row">${i++}</th>`);
            $mail_btn_wrapper = $('#align-wrapper-mailbtn');
            $tr.append($th);
            for (const prop in student) {
                $td = $(`<td>${student[prop]}</td>`);
                $tr.append($td);
            }
            $tbody.append($tr);
        });
        $mail_btn_wrapper.append($mail_btn);
        
        bindMailbtnEvent($tbody);//binding event to mail btn only after it has been added to page

    }

    function bindMailbtnEvent($tbody){
        //mail event
        $mail_btn = $('#align-wrapper-mailbtn .btn');
        $mail_btn.on('click',(e)=>{

            $mail_btn.prop('disabled',true);
            $mail_btn.text('Please wait..');
            $upload_btn.prop('disabled',true);

            $.post('../api/student/mail.php',{
                tpo_id: tpo_id
            },(data)=>{
                alert(data.msg);
                $tbody.empty();
                $mail_btn_wrapper.empty();
                $upload_btn.prop('disabled',false);

            })
            .fail(data =>{
                alert(data.msg);
                $upload_btn.prop('disabled',false);
            });
        });
    }

    





});