<form action="/shared/save/note" method="post" id="modal-form" enctype="multipart/form-data">
    <h2 class="form-signin-heading">Fyll i fälten och tryck på "Spara" längst ner i fönstret.</h2>
    <?php echo $this->session->flashdata('msg');?>

     <input type="hidden"  value="<?php echo $data['id']; ?>" name="id" class="form-control" placeholder="id">
     
    <label for="titel" class="">Titel</label>
    <input type="text" value="<?php echo $data['titel']; ?>" name="titel" class="form-control" placeholder="Titel" required>

    <label for="note" class="">Beskrivning</label>
    <textarea rows="5" name="note" class="form-control" placeholder="Beskrivning" required><?php echo $data['note']; ?></textarea>


    <label for="expire" class="">Dölj notis efter datum</label>
    <input type="text"  value="<?php echo $data['expire']; ?>" name="expire" class="form-control" placeholder="Dölj notis efter datum">


    <label for="expire" class="">Välj meddelandefärg</label>
    <?php
    foreach($noteColors as $index => $value)
    {
        $checked = ($data['color'] == $index) ? 'checked="checked"' : ""
        ?>
    <div class="alert alert-<?php echo $index; ?>" role="alert">
       <label><input <?php echo $checked; ?> type="radio" name="color" value="<?php echo $index;?>" />
           Färg <?php echo $value; ?></label>
   </div>  

    
<?php
    }
    ?>
    <?php require_once '_upload_file_button.php'; ?>
    <!--
    <button class="btn btn-lg btn-primary btn-block" type="submit">Skapa</button>
    -->
</form>