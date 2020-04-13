<div class="container">
    
  <div class="row">
    <ul class="list-group">
  <li class="list-group-item">Här visas aktuella nyheter, notiser samt händelser.
      För att se gamla nyheter, notiser och händelser, tryck på motsvarande
  namn i menyraden.
  <?php if((int)$this->session->userdata('ga_number') > 0)
  {
      $ga = $this->session->userdata('ga_number');
      echo ' Prenumerara på GA'.$ga.':s <a href="webcal://'.$_SERVER["SERVER_NAME"].'/kalenderprenumeration/ga'.$ga.'">kalender</a>.';
  }
  ?>

  </li>
  
</ul>
  </div>
      <br />
  <div class="row">
    <div class="col">
        <h1>Nyheter 
            <button title="Skapa nyhet" type="button" class="btn btn-primary j-dashboard-button" data-type='news'>+</button>
        </h1>
        <?php
        if(count($activeNews) < 1)
        {
            echo 'Det finns inga aktuella nyheter';
        }
        else
        {
        ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">&nbsp;</th>
            </tr>
          </thead>
        <?php
        foreach($activeNews as $news)
        {?>
          <tr>
              <td>
                  <?php echo $news['created_by_role']; ?>,
                  <span class='news'>
                      <?php echo date("Y-m-d", strtotime($news['created'])); ?>
                    <?php
                    if($news['created_by_role'] == $this->session->userdata('role'))
                    {
                    echo dropdown($news['id'],'news');
                    }
                    ?>
                  <br />
            <?php if($news['titel'] != '')
            {
                ?>
                  <strong><?php echo $news['titel']; ?></strong><br />
            <?php
            }
            if($news['image_path'] !== NULL)
            {
                echo '<img class="img-fluid" alt="Bild" src="'.$news['image_path'].'" />';
            }
            ?>
            <?php echo $news['description']; 
            if(date("Ymd", strtotime($news['updated'])) > date("Ymd", strtotime($news['created'])))
            {
                $date = date("Y-m-d", strtotime($news['updated']));
                echo '<div class="dashbord-info-text">Uppdaterad '.$date.'</span>';
            }
            
            ?></td>

          </tr>
        <?php
        }
        ?>
        </table>
        <?php
        }
        ?>
    </div>        
    <div class="col">
        <h1>Aktuella notiser
            <button title="Skapa notis" type="button" class="btn btn-primary j-dashboard-button" data-type="note">+</button>
        </h1>

        <?php
        if(count($activeNotes) < 1)
        {
            echo 'Det finns inga aktuella notiser';
        }
        else
        {
        ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">&nbsp;</th>
            </tr>
          </thead>
        <?php
        foreach($activeNotes as $note)
        {?>
          <tr class="table-<?php echo $note['color'];?>">
              <td>
                  
                  <?php echo date("Y-m-d", strtotime($note['created'])); ?>
                    <?php
                    if($note['created_by_role'] == $this->session->userdata('role'))
                  {
                    echo dropdown($note['id'],'note');
                  }
                  ?>

                  <br />
                  
              <strong><?php echo $note['titel']; ?></strong><br />
              <?php
            if($note['image_path'] !== NULL)
            {
                echo '<img class="img-fluid" alt="Bild" src="'.$note['image_path'].'" />';
            }
              echo $note['note']; ?>
              <?php
              if($note['expire'] != '')
              {
                  echo '<div class="dashbord-info-text">Försvinner '.$note['expire'].'</div>';
              }
              ?>
          </tr>
        <?php
        }
        ?>
        </table>
        <?php
        }
        ?>
    </div>        
    <div class="col">
        <h1>Kalender
            <button title="Skapa händelse" type="button" class="btn btn-primary j-dashboard-button" data-type='event'>+</button>
        </h1>
        <?php
        if(count($activeEvents) < 1)
        {
            echo 'Det finns inga aktuella händelser';
        }
        else
        {
        ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">&nbsp;</th>
            </tr>
          </thead>
        <?php
        $dayArr = days();
        foreach($activeEvents as $event)
        {
            $day = date("D", strtotime($event['start']));
            $time = '';
            $wholeDay = (int)$event['whole_day'];
            if(!$wholeDay)
            {
                $tmp1 = explode(' ', $event['start']);
                $tmp2 = explode(' ', $event['end']);
                $time = substr($tmp1[1],0,5).' - '.substr($tmp2[1],0,5);
            }
            ?>
          <tr>
              <td>
                  <?php
                  echo $dayArr[$day].' '. date("d/m-y", strtotime($event['start']));
                  echo ' '.$time;
                  
                  if($event['created_by_role'] == $this->session->userdata('role'))
                  {
                    echo dropdown($event['id'],'event');
                  }
                  ?>
              <br />
                  <strong><?php echo $event['titel']; ?></strong><br />
                  <?php
                    if($event['image_path'] !== NULL)
                    {
                        echo '<img class="img-fluid" alt="Bild" src="'.$event['image_path'].'" /><br />';
                    }
                  echo $event['note']; ?><br />
                  Plats: <?php echo $event['location']; ?><br />
                  <?php
                  if($this->session->userdata('role') == $this->user_model::ROLE_ADMIN)
                  {
                  echo 'Puplik: ';
                  echo ($event['public']) ? 'Ja' : 'Nej'; 
                  echo '<br />';
                  }
                  ?>
              
              
              </td>
          </tr>
        <?php
        }
        ?>
        </table>
        <?php
        }
        ?>
    </div>
  </div>
</div>