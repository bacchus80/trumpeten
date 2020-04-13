<form action="/shared/save/user" method="post" id="modal-form">
    <h2 class="form-signin-heading">Fyll i fälten och tryck på "Spara" längst ner i fönstret.</h2>
    <?php echo $this->session->flashdata('msg');?>
    <input type="hidden" name="id" class="form-control" placeholder="id">
     
  <label for="firstname" class="">Förnamn</label>
  <input type="text" value="<?php echo $data['firstname']; ?>" name="firstname" class="form-control" placeholder="Förnamn" autofocus" required>

  <label for="lastname" class="">Efternamn</label>
  <input type="text" value="<?php echo $data['lastname']; ?>" name="lastname" class="form-control" placeholder="Efternamn" required>

  <label for="email" class="">E-postadress</label>
  <input type="text" value="<?php echo $data['email']; ?>" name="email" class="form-control" placeholder="E-postadress" required>

  <label for="role" class="">Användarbehörighet</label>
  <select name="role" class="form-control" required id="user-role">
      <?php
      foreach($userGroupValueList as $key => $value)
      {
        $selected = '';
        if($data['role'] == $key)
        {
            $selected = 'selected';
        }
        echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';  
      }
      ?>
  </select>
  <div id="ga-group" class="hide">
    <label for="role" class="">GA-nummer</label>
    <select name="ga_number" class="form-control hidden">
        <option value="0">Välj</option>
        <?php
        for($i = 7; $i <= $this->site_model::NUMBER_OF_AREAS; $i++)
        {
        $selected = '';
        if($data['ga_number'] == $i)
        {
            $selected = 'selected';
        }
          echo '<option '.$selected.' value="'.$i.'">GA '.$i.'</option>';  
        }
        ?>
    </select>
  </div>
</form>