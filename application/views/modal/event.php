<form type="" action="/shared/save/event" method="post" id="modal-form" enctype="multipart/form-data">
    <?php echo $this->session->flashdata('msg');?>

     <input type="hidden" value="<?php echo $data['id']; ?>" name="id" class="form-control" placeholder="id">
     
    <label for="start" class="">Start</label>
    <input type="text" value="<?php echo $data['start']; ?>" name="start" class="form-control" placeholder="Start" required autofocus>

    <label for="end" class="">Slut</label>
    <input type="text" value="<?php echo $data['end']; ?>" name="end" class="form-control" placeholder="Slut" required>

    <label for="titel" class="">Titel</label>
    <input type="text" value="<?php echo $data['titel']; ?>" name="titel" class="form-control" placeholder="Titel" required>

    <label for="note" class="">Beskrivning</label>
    <textarea name="note" class="form-control" placeholder="Beskrivning" required><?php echo $data['note']; ?></textarea>

    <label for="whole_day" class="">Heldag</label>
    <input type="text" value="<?php echo $data['whole_day']; ?>" name="whole_day" class="form-control" placeholder="Heldag">

    <label for="location" class="">Plats</label>
    <input type="text" value="<?php echo $data['location']; ?>" name="location" class="form-control" placeholder="Plats">

    <?php require_once '_upload_file_button.php'; ?>
    
    <?php
    if($isBoardMember)
    {
        ?>
    <div>
    <label class="_">Publik händelse</label>
    <label><input <?php echo ($data['public'] == 1) ? 'checked="checked"' : "" ; ?> type="radio" name="public" class="form-control" value="1">Ja</label>
    <label><input <?php echo ($data['public'] == 0) ? 'checked="checked"' : "" ; ?> type="radio" name="public" class="form-control" value="0">Nej</label>
    </div>
    <?php
    }
    ?>
        </form>