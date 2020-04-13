Modalt fönster
 <div class="col-md-4 col-md-offset-4">
   <form class="form-signin" action="/db/create" method="post">
     <h2 class="form-signin-heading">Skapa nyhet</h2>
     <?php echo $this->session->flashdata('msg');?>
     <input type="hidden" name="db_type" value='news' class="form-control">
     <label for="titel" class="sr-only">Titel</label>
     <input type="text" name="titel" class="form-control" placeholder="Titel">
     
     <label for="description" class="sr-only">Beskrivning</label>
     <textarea rows="5" name="description" class="form-control" placeholder="Beskrivning" required></textarea>
     
     <button class="btn btn-lg btn-primary btn-block" type="submit">Skapa</button>
   </form>
 </div>