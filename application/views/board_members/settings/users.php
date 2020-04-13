<?php
require_once(__DIR__.'/../breadcrumb.php');
?>
<h1>Användare
            <button title="Ny användare" type="button" class="btn btn-primary j-dashboard-button" data-type="user">+</button>

</h1>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">Användare</th>
      <th scope="col">E-postadress</th>
      <th scope="col">GA</th>
      <th scope="col">&nbsp;</th>
    </tr>
  </thead>
<?php
$group = '';
foreach($users as $user)
{
    if($group != $user['role'])
    {
        $group = $user['role'];
        echo '<tr>';
        echo '<td colspan="4"><b>'.$roleTranslation[$user['role']].'</b></td>';
        echo '</tr>';
    }
    echo '<tr>';
    echo '<td>'.$user['firstname'].' '.$user['lastname'].'</td>';
    echo '<td>'.$user['email'].'</td>';
    echo '<td>'.$user['ga_number'].'&nbsp;</td>';
    echo '<td>';
    if($user['role'] == $this->user_model::ROLE_GA ||
        $user['role'] == $this->user_model::ROLE_ADMIN && $amountBoardMembers > 1 )
    {
        echo dropdown($user['id'],'user');
    }
    echo '</td>';
    echo '</tr>';
}
?>
    </table>