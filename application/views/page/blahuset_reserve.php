<h2 class="form-signin-heading">Boka Blå huset</h2>
<h5>Fyll i formuläret och tryck på "Skicka". För att bekräfta bokningen behöver du trycka på länken i mailet som skickas till dig.</h5>
<h6>Bokingen blir definitv när [VEM?] hör av sig till dig via telefon eller e-post.</h6>
<hr />
<?php print_r($validation); ?>
<form action="/blahuset/boka" method="post" id="modal-form">
     <?php echo $this->session->flashdata('msg');?>
     
     <label for="start" class="_sr-only">Start</label>
     <input type="text" value="<?php echo $model["start"];?>" name="start" class="form-control" placeholder="Start" required autofocus>

     <label for="end" class="_sr-only">Slut</label>
     <input type="text" value="<?php echo $model["end"];?>" name="end" class="form-control" placeholder="Slut" required>

     <label for="booking_type" class="_sr-only">Bokingstyp</label>
     <select  name="booking_type" rrequired class="form-control">
       <?php
       foreach($valueListBookingTypes as $key => $val)
       {
           $selected = "";
           if($model["booking_type"] == $key)
           {
               $selected = 'selected="selected"';
           }
           echo '<option '.$selected.' value="'.$key.'">'.$val.'</option>';
       }
       ?>
     </select>
     
     <label for="firstname" class="_sr-only">Förnamn</label>
     <input type="text" value="<?php echo $model["firstname"];?>" name="firstname" class="form-control" required placeholder="Förnamn">
        
     <label for="lastname" class="_sr-only">Efternamn</label>
     <input type="text" value="<?php echo $model["lastname"];?>" name="lastname" class="form-control" required placeholder="Efternamn">
               
     <label for="street" class="_sr-only">Gata</label>
     <input type="text" value="<?php echo $model["street"];?>" name="street" class="form-control" required placeholder="Gata">
        
     <label for="email" class="_sr-only">E-postadress</label>
     <input type="text" value="<?php echo $model["email"];?>" name="email" class="form-control" required placeholder="E-postadress">
        
     <label for="phone" class="_sr-only">Telefon</label>
     <input type="text" value="<?php echo $model["phone"];?>" name="phone" class="form-control" required placeholder="Telefon">
     
     <label><input type="checkbox" value="1" name="ok" rrequired class="form-group">Jag godkänner att mina kontaktuppgifter sparas. Uppgifterna kommer bara att användas för att kontakta dig.
     </label>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Skicka</button>
   </form>