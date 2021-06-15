$(function(){
    var dpfile = null;
    var student_id = $('#student-id').val();
    //var new_login = $('#new-login').val() ;
    
    sendStudentReadReq();    

    
    function sendStudentReadReq(){
        $.post('../api/student/read.php',{
            student_id: student_id
        },data=>{
            showProfileData(data);
        })
        .fail(()=>{
            alert('something went wrong');
        });
    }
    
    
    $('#dob').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1000:3000"
    });
    
    //console.log($('#dp_url').val());

    // change and preview profile pic
    $("#profile-pic").change(function(){
        readURL(this);
    });

    function readURL(input) {
        let valid_img_types  = ['image/jpg','image/jpeg','image/png'];
        console.log(input.files[0]);
        if (input.files && input.files[0] && valid_img_types.includes(input.files[0].type)) {
            var reader = new FileReader();

            reader.onload = function (e) {
                console.log(e);
                $('.picture img').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
            dpfile = input.files[0];
        }
    }
    //get data from student
    $('.save-btn-cont .btn').on('click',function(){
        
        let email = $('#email').val();
        let contact = parseInt($('#contact').val());
        let dob = $('#dob').val();
        let passout_year = $('#passout-year').val();
        let gender = $('#gender').val();
        let inst = $('#inst').val();
        let ssc_per = parseInt($('#ssc-per').val());
        let hsc_dip_per = parseInt($('#hsc-dip-per').val()) ;
        let cca = parseInt($('#cca').val()) ;
        let active_kt = parseInt($('#active-kt').val()) ;
        
        let sem_arr = [];
        $('.sem').each(function(){
            console.log(this);
            console.log(parseInt($(this).val()));
            if (!isEmpty(parseFloat($(this).val()))) {
                sem_arr.push(parseFloat($(this).val()));
            }
        });
        console.log(sem_arr);
        if (!isEmpty(email)&&!isEmpty(contact)&&gender != 'select'&&!isEmpty(dob)&&!isEmpty(passout_year)&&!isEmpty(inst)&&!isEmpty(ssc_per)&&!isEmpty(hsc_dip_per)&&!isEmpty(cca)&&!isEmpty(active_kt)&&sem_arr.length == 8) {
            dob = dob.split('/');
            dob = `${dob[2]}-${dob[0]}-${dob[1]}`;
            console.log(ssc_per,hsc_dip_per,cca,active_kt,sem_arr[0],sem_arr[1],sem_arr[2],sem_arr[3],sem_arr[4],sem_arr[5],sem_arr[6],sem_arr[7]);

            //alert('good');
            console.log(student_id);
            $.post('../api/student/update-prof.php',{
                
                email: email,
                contact: contact,
                gender:gender,
                dob: dob,
                passout_year: passout_year,
                institute: inst,
                ssc_per: ssc_per,
                hsc_dip_per: hsc_dip_per,
                cca: cca,
                active_kt: active_kt,
                sem1: sem_arr[0],
                sem2: sem_arr[1],
                sem3: sem_arr[2],
                sem4: sem_arr[3],
                sem5: sem_arr[4],
                sem6: sem_arr[5],
                sem7: sem_arr[6],
                sem8: sem_arr[7],
                student_id: student_id

            },data=>{
                alert(data.msg);
                sendUploadDpReq();
            })
            .fail((data)=>{
                console.log(data);
               alert('something went wrong');
            });
          
        }
        else{
            alert('Please fill all the details.');

        }

      //  console.log(email,contact,dob,passout_year,gender,inst);


    });
    console.log(isEmpty(""));

    function showProfileData(data){
        console.log(data);
        let student = data.records[0];
        let nl = student.new_login;
        $('#email').val(student.email);
        if (nl == 0) {
            console.log('hel');
            $('#contact').val(student.contact);
            $('#gender').val(student.gender);
            $('#dob').val(student.dob);
            $('#passout-year').val(student.passout_year);
            $('#inst').val(student.institute);
            //$('#email').val(student.email);

            $('#ssc-per').val(student.ssc_per);
            $('#hsc-dip-per').val(student.hsc_dip_per);
            $('#cca').val(student.current_course_agg);
            $('#active-kt').val(student.active_kt);

            const {sem1,sem2,sem3,sem4,sem5,sem6,sem7,sem8} = student;
            let sem = [sem1,sem2,sem3,sem4,sem5,sem6,sem7,sem8];
            let i = 0;
            $('.sem').each(function(){
                $(this).val(sem[i]);
                i++;
            });
        
        }
    }

    function isEmpty(v) {
        return (v == NaN || v.length === 0 );
    }

    function sendUploadDpReq(){
        if (dpfile) {
            let fd = new FormData();
            fd.append('dpfile',dpfile);
            fd.append('student_id',student_id);
            $.ajax({
                url: '../api/student/upload-dp.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(data){
                    alert(data.msg);
                    location.reload();
                },
                error: function(data){
                    console.log(data);
                    alert('profile pic upload failed');
                }
            });
        }
    }
});