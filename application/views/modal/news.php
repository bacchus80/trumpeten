<form action="/shared/save/news" method="post" id="modal-form" enctype="multipart/form-data">
  <?php echo $this->session->flashdata('msg');?>

     <input type="hidden" value="<?php echo $data['id']; ?>" name="id" class="form-control" placeholder="id">
     
    <label for="titel" class="">Titel</label>
  <input type="text" value="<?php echo $data['titel']; ?>" name="titel" class="form-control" placeholder="Titel">

  <label for="description" class="">Beskrivning</label>
  <textarea rows="5" name="description" class="form-control" placeholder="Beskrivning" required><?php echo $data['description']; ?></textarea>
<br />
    <?php require_once '_upload_file_button.php'; ?>
  <!--
  <button class="btn btn-lg btn-primary btn-block" type="submit">Skapa</button>
  -->
</form>