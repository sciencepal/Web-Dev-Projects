<script type="text/javascript">
    function validate(){
        var validator = $('#login_frm').validate({
            rules:{
                'user_id':{
                    required : true,
                },
                'password':{
                    required :true,
                }
            },
            messages:{
                'user_id':{
                    required:"<font class='errcls' color='red'>**This field cannot be left blank**</font>"
                },
                'password':{
                    required :"<font class='errcls' color='red'>**This field cannot be left blank**</font>"
                }
            }
        });
        x=validator.form();
        return x;
    }
</script>