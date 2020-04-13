<form action="/shared/save/booking" method="post" id="modal-form">
     <h2 class="form-signin-heading">Skapa bokning</h2>
     <?php echo $this->session->flashdata('msg');?>
     <input type="hidden" name="id" class="form-control" placeholder="id">
     
     <label for="start" class="sr-only">Start</label>
     <input type="text" name="start" class="form-control" placeholder="Start" required autofocus>

     <label for="end" class="sr-only">Slut</label>
     <input type="text" name="end" class="form-control" placeholder="Slut" required>

     <label for="booking_type" class="sr-only">Bokingstyp (1 barnkalas, 2 övrigt)</label>
     <select  name="booking_type" class="form-control">
         <option value="">Välj</option>
         <option value="1">Barnkalas</option>
         <option value="2">Övrigt</option>
     </select>
     
     <label for="firstname" class="sr-only">Förnamn</label>
     <input type="text" name="firstname" class="form-control" placeholder="Förnamn">
        
     <label for="lastname" class="sr-only">Efternamn</label>
     <input type="text" name="lastname" class="form-control" placeholder="Efternamn">
               
     <label for="street" class="sr-only">Gata</label>
     <input type="text" name="street" class="form-control" placeholder="Gata">
        
     <label for="email" class="sr-only">E-postadress</label>
     <input type="text" name="email" class="form-control" placeholder="E-postadress">
        
     <label for="phone" class="sr-only">Telefon</label>
     <input type="text" name="phone" class="form-control" placeholder="Telefon">

<!--     <button class="btn btn-lg btn-primary btn-block" type="submit">Skapa</button> -->
   </form>