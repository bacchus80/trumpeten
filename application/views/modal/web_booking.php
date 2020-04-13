<form action="/shared/save/webbooking" method="post" id="modal-form">
     <h2 class="form-signin-heading">Fyll i formuläret och tryck på "Skicka"</h2>
     <h4>För att bekräfta preliminärbokningen behöver du trycka på länken i mailet som skickas till dig</h4>
     <?php echo $this->session->flashdata('msg');?>
     
     <label for="start" class="_sr-only">Start</label>
     <input type="text" name="start" class="form-control" placeholder="Start" required autofocus>

     <label for="end" class="_sr-only">Slut</label>
     <input type="text" name="end" class="form-control" placeholder="Slut" required>

     <label for="booking_type" class="_sr-only">Bokingstyp (1 barnkalas, 2 övrigt)</label>
     <select  name="booking_type" class="form-control">
         <option value="">Välj</option>
         <option value="1">Barnkalas</option>
         <option value="2">Övrigt</option>
     </select>
     
     <label for="firstname" class="_sr-only">Förnamn</label>
     <input type="text" name="firstname" class="form-control" placeholder="Förnamn">
        
     <label for="lastname" class="_sr-only">Efternamn</label>
     <input type="text" name="lastname" class="form-control" placeholder="Efternamn">
               
     <label for="street" class="_sr-only">Gata</label>
     <input type="text" name="street" class="form-control" placeholder="Gata">
        
     <label for="email" class="_sr-only">E-postadress</label>
     <input type="text" name="email" class="form-control" placeholder="E-postadress">
        
     <label for="phone" class="_sr-only">Telefon</label>
     <input type="text" name="phone" class="form-control" placeholder="Telefon">
     
     <label><input type="checkbox" name="ok" class="form-group">Jag godkänner att mina kontaktuppgifter sparas. Uppgifterna kommer bara att användas för att kontakta dig.
     </label>

<!--     <button class="btn btn-lg btn-primary btn-block" type="submit">Skapa</button> -->
   </form>