<h1>LOGIN PAGE</h1>
<form enctype="multipart/form-data" method="post" id="login_user">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="user_email" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="user_password" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    $(document).ready(function(){
        $("#login_user").submit(function(event){
            event.preventDefault();
            console.log("inform");
            let data = new FormData(this);
            let url = "http://localhost/clones/test2/public/api/login-user";
            jQuery.ajax({
                url:url,
                data:data,
                type:"POST",
                processData:false,
                contentType:false,
                cache:false,
                success:function(result){
                    console.log(result);
                    console.table(result);
                    if(result.status == 200){
                        window.location.href="http://localhost/clones/test2/public/home"
                    }   
                }
            });
        });
    });
</script>
