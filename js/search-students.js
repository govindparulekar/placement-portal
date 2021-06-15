$(function(){
    var $search = $('#search .btn');
    var $def_msg = $(`<div class="default-msg-wrapper d-flex justify-content-center">
                        <div class="msg"></div>
                    </div>`);
    
    $search.on('click',function(){
        
        var name = $('#name input').val();
        var roll = $('#roll input').val();
        var branch_id = $('#select-branch select').val();
        if (name&&branch_id!=0&&!roll) {
            searchStudentReq(branch_id,'name',name);
        }
        else if(roll&&branch_id!=0&&name==""){
           // alert();
            searchStudentReq(branch_id,'roll',roll);
        }
        else if(branch_id!=0){
            alert(branch_id);
            searchStudentReq(branch_id,'branch');
        }
        else{
            alert('search by name and branch or roll and branch or just branch');
        }
    });

    function searchStudentReq(branch_id,q,param = null,){
        switch (q) {
            case 'name':
                $.post('../api/student/read.php',{
                    name: param,
                    branch_id: branch_id,
                    tpo_id: tpo_id
                },data=>{
                    renderData(data);
                })
                .fail(data=>{
                    $('.main .container').html($def_msg);
                    $('.msg').text('No record found');
                });
                break;
            case 'roll':
                //console.log(param);
                $.post('../api/student/read.php',{
                    roll_no: param,
                    branch_id: branch_id,
                    tpo_id: tpo_id
                },data=>{

                    renderData(data);
                })
                .fail(data=>{
                    $('.main .container').html($def_msg);
                    $('.msg').text('No record found');                 
                });
                break;
            case 'branch':
                $.post('../api/student/read.php',{                
                    branch_id: branch_id,
                    tpo_id: tpo_id
                },data=>{
                    renderData(data);
                })
                .fail(data=>{
                    $('.main .container').html($def_msg);
                    $('.msg').text('No record found');
                });
                break;
            default:
                break;
        }
    }

    function renderData(data){
        $table = $(`<div id="table-cont">
                        <table class="table" style = "background-color: white">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Roll NO</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>`);
            $('.main .container').html($table);

        let students = data.records;
        let i = 1;
        students.forEach(student =>{
            $tr = $('<tr>');
            $tr.append($(`<th scope = "row">${i++}</th>`));
            for (const prop in student) {
                if (prop == 'dob') {
                    break;
                }
                if (prop !== 'student_id') {
                    $tr.append(`<td>${student[prop]}</td>`);
                }

            }
            $op_td = $(`<td>
                            <a href = "profile.php?student_id=${student.student_id}&student-dp=${student.dp}">see profile</a>
                        </td>`);
                        //console.log(stu);
            $tr.append($op_td);
            console.log($tr[0]);
            $('tbody').append($tr);
        });
    }
});