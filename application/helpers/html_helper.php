<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('dropdown')) {

    function dropdown($dropDownId, $type)
    {
?>
    <span class="dropdown">
  <button title="Redigera" class="btn btn-secondary j-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    ...
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
       data-type="<?php echo $type; ?>" data-id="<?php echo $dropDownId; ?>">
    <a class="dropdown-item j-dropdown-crud">Ändra</a>
    <a class="dropdown-item j-dropdown-crud" data-type="delete">Radera</a>
  </div>
</span>
    <?php
    }
}
?>