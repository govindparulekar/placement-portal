$(function(){
    var $select_branch_inp = $('select');

    $select_branch_inp.on('change',()=>{
        let branch_id = $select_branch_inp.val();
        if (branch_id != 0) {
            $.post('../api/drive/read-by-branch.php',{
                tpo_id: 3131,
                branch_id: branch_id
            },data =>{
                console.log(data);
            });

        }
        
    });





});