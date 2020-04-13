<h1>Notiser</h1>
<?php
if($createStatus) {
 echo "Notisen har skapats";   
}


$displayAtValueList = [
    '' => 'Välj',
    'main' => 'Huvudsida',
    'all' => 'Alla',
    'ga' => 'GA',
];
?>

 <div class="col-md-4 col-md-offset-4">
   <form class="form-signin" action="/db/create" method="post">
     <h2 class="form-signin-heading">Skapa notis</h2>
     <?php echo $this->session->flashdata('msg');?>
     <label for="date" class="sr-only">Datum</label>
     <input type="text" name="date" class="form-control" placeholder="Datum" autofocus>

     <label for="titel" class="sr-only">Titel</label>
     <input type="text" name="titel" class="form-control" placeholder="Titel" required>
     
     <label for="note" class="sr-only">Beskrivning</label>
     <textarea rows="5" name="note" class="form-control" placeholder="Beskrivning" required></textarea>

          
     <label for="expire" class="_sr-only">Dölj notis efter datum</label>
     <input type="text" name="expire" class="form-control" placeholder="Dölj notis efter datum">
            
     <button class="btn btn-lg btn-primary btn-block" type="submit">Skapa</button>
   </form>
 </div>

