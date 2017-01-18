
function get_fullname(value) {
    // alert(value);
    $.ajax({
        type: "GET",
        url: "get_full_name.php",
        data: "choice="+value,
        success: function(data){
            $('#fname').val(data);
        }
    })
}
