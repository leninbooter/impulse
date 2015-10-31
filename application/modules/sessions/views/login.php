<div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">          

          <div class="inner cover">
            <div id="row">                
                <div id="" class="text-center col-md-12" style="vertical-align:middle">
                    <h1><b>I</b>MPULSE
                    <br/>                   
                </div>
            </div>
             <div class="row">
                <div id="" class="text-center col-md-12" style="vertical-align:middle">                    
                    <form class="form-inline " role="form"  id="login_form" method="post">
                       <h2>Login</h2>
                        <fieldset>                            
                            <legend></legend>
                            <div class="form-group">
                            <label for="email">Usuario</label>
                            <input type="text" id="email" name="email" class="form-control input-sm" placeholder="" required autofocus>
                        </div>
                        <div class="form-group">                        
                            <label for="inputPassword">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control input-sm" placeholder="" required>
                        </div>
                        <button class="btn btn-primary btn-sm" type="submit">Acceder</button>
                        </fieldset>
                        <!-- <h2 class="form-signin-heading ">Login</h2> -->                        
                    </form>

                </div>
            </div>  
            
          </div>
          

        </div>

      </div>

    </div>
    
<script type="text/javascript">
    
    window.onload = function(e) {
        $('#email').focus();
        
        $('#login_form').submit(function(event) {

            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?=base_url('index.php/sessions/start')?>",
                data: $(this).serialize(),
                dataType: "json"
                }).done(function( json ) {
                    if(json.result == "ok")
                    {			
                        location.href=json.redirectTo;
                    }
                    else if(json.result = "KO"){
                        alert(json.message);
                    }
                    
                }).fail(function(){
                    alert("Technical error");
                });
        });
    }
</script>