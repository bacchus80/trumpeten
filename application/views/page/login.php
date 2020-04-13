<div class="container">
 <div class="col-md-4 offset-md-4">
   <form class="form-signin" action="/sida/auth" method="post">
     <h2 class="form-signin-heading">Inloggning@trumpeten</h2>
     <?php echo $this->session->flashdata('msg');?>
     <label for="username" >E-postadress</label>
     <input type="email" name="email" class="form-control" placeholder="E-postadress" required autofocus>
     <label for="password">Lösenord</label>
     <input type="password" name="password" class="form-control" placeholder="Lösenord" required>
     <div class="checkbox">
       <label>
         <input type="checkbox" value="remember-me"> Kom ihåg mig
       </label>
     </div>
     <div><a href="/glomt">Jag har glömt lösenordet</a></div><br />
     <button class="btn btn-primary btn-block" type="submit">Logga in</button>
   </form>
 </div>
 </div> <!-- /container -->
