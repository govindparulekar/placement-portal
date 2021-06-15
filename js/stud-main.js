$(function(){
    var student_id = $('#student-id').val();
    console.log(student_id);
    $.post('../api/student/read.php',{
        student_id: student_id
    },data=>{    
        console.log(data);
       let student = data.records[0];
        $('.picture img').attr('src',data.records[0].dp);
        $('.profile-img img').attr('src',  data.records[0].dp);

        if (student.new_login == 1 && $('title').text() != 'My Profile') {
         //alert('Please complete your profile first'); 
         window.location = 'profile.php';  
        }
    })
    .fail(data=>{
        console.log(data);
    });
});