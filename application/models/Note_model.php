<?php
class Note_model extends CI_Model
{

    
    function writeNotes()
    {
                $fh = fopen(BASEPATH."../assets/notes/notes.txt", "w");// or die("can't open file");

        $notes = $this->note_model->get_notes();
//        echo json_encode( $notes);exit;
        $ids = [];
        $json = [];
        foreach($notes as $note)
        {
            $ga = (int)$this->session->userdata('ga_number');
            $show_board_note_text = false;
            if($ga > 0 && $ga != str_replace("ga", "", $note['display_at']))
            {
                $show_board_note_text = true;
            }

            /*            
            $json[] = [
                'id' => $note['id'],
                'js_id' => 'note_'.$note['id'],
                'show_board_note_text' => $show_board_note_text,
                'titel' => $note['titel'],
                'note' => $note['note'],
                'color' => $note['color'],
                'image_path' => $note['image_path'],
            ];
            */
            /*
                $boardNote = '';
                $ga = (int)$this->session->userdata('ga_number');
                if($ga > 0 && $ga != str_replace("ga", "", $note['display_at']))
                {
                    $boardNote = '<span class="badge badge-primary badge-pill right">från styrelsen</span>';
                }
                $html = '<div class="alert alert-'.$note['color'].'" role="alert">';
                $html .= '<button type="button" data-id="note_'.$note['id'].'" class="close" data-dismiss="alert" aria-label="Close">';
                $html .= '<span aria-hidden="true">&times;</span></button>';

                $html .= '<div>'.$note['titel'].$boardNote.'</div>';
                if($note['image_path'] !== NULL)
                {
                    $html .= '<div><img class="img-fluid" alt="Bild" src="'.$note['image_path'].'" /></div>';
                }
                $html .= '<div>'.$note['note'].'</div>';
                $html .= '</div>';*/
                            $boardNote = '';
                $ga = (int)$this->session->userdata('ga_number');
                if($ga > 0 && $ga != str_replace("ga", "", $note['display_at']))
                {
                    $boardNote = '<span class="badge badge-primary badge-pill right">från styrelsen</span>';
                }
            ob_start();
            ?><div class="alert alert-<?php echo $note['color'];?>" role="alert">
                <?php /*
                <button type="button" onclick="myclose('note_<?php echo $note['id']; ?>')" data-id="note_<?php echo $note['id']; ?>" class="j-modal-close close " data-dismiss="alert" aria-label="Close">
                    <span class="" >&times;</span>
                  </button>
*/ ?><div><?php echo $note['titel'].$boardNote; ?></div>
                <?php
                if($note['image_path'] !== NULL)
                {
                    echo '<div><img class="img-fluid" alt="Bild" src="'.$note['image_path'].'" /></div>';
                }
                ?>
                <div><?php echo $note['note']; ?></div>
            </div><?php
            $json[] = ob_get_contents();
            $ids[] = "note_".$note['id'];
ob_end_clean(); //                $json[] = $html;
        }     
        $arr = array();
        $arr["data"] = $json;
        $arr["ids"] = $ids;
        $arr["size"] = count($arr["data"]);
        echo json_encode($arr);
        
        
        fwrite($fh, json_encode($arr));
        fclose($fh);
    }
    
    
    function get_notes()
    {
        $displayAt = '"all", "main"';
        if((int)$this->session->userdata('ga_number') > 0)
        {
            $displayAt = '"all", "main", "ga'.$this->session->userdata('ga_number') .'"';
        }
        $date = date("Y-m-d");
        $this->db->select('*');
        $this->db->from('note');
        $this->db->where('display_at IN('.$displayAt.')');
        $this->db->where('expire IS NULL or expire >= "'.$date.'"');
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_active_main_notes()
    {
        $date = date("Y-m-d");
        $this->db->select('*');
        $this->db->from('note');
        $this->db->where('(expire IS NULL or expire >= "'.$date.'")');
        $this->db->where('display_at IN("all")');
        $this->db->order_by('display_at', 'ASC');
        $this->db->order_by('created', 'DESC');
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;        
    }
    
    
    function get_old_main_notes()
    {
        $date = date("Y-m-d");
        $this->db->select('*');
        $this->db->from('note');
        $this->db->where('display_at IN("all")');
        $this->db->where('(expire IS NOT NULL or expire < "'.$date.'")');
        $this->db->order_by('display_at', 'ASC');
        $this->db->order_by('created', 'DESC');
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;        
    }
    
    
    function get_ga_notes($ga){
        $date = date("Y-m-d");
        $this->db->select('*');
        $this->db->from('note');
        $this->db->where('display_at IN("all", "'.$ga.'")');
        $this->db->where('(expire IS NULL or expire >= "'.$date.'")');
        if($ga != '')
        {
            $this->db->order_by('display_at', 'ASC');
            $this->db->order_by('created', 'DESC');
        }
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;
        
    }
    /*
     * $this->db->select('title, dvd, date');
$this->db->from('hh_events');
$this->db->limit('7');
$this->db->like("(dvd LIKE '1' OR theater LIKE '1')");
$this->db->where("(date >= " . now() . ")");
$data['events'] = $this->db->get();

$this->db->select();
$this->db->from('hh_events');
$this->db->where('(dvd = 1 AND date >= NOW()) OR (theater = 1 AND date >= NOW())');
$this->db->limit('6');
$this->db->order_by('date ASC');
     */
    
    function colors()
    {
        return [
          'primary' => '1',
          'secondary' => '2',
          'success' => '3',
          'danger' => '4',
          'warning' => '5',
          'info' => '6',
          'light' => '7',
          'dark' => '8',
        ];
    }
    
    
    function test()
    {
        return "note_model working";   
    }

}