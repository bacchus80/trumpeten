<?php
class html_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->library('form_validation');
        $this->load->helper("imagetodata_helper");
    }
    
    
    function index()
    {
        $this->load->view('image_view');
    }

    function image_to_data()
    {
        $URL = $this->input->post('img_name');

        // Validation for image url.
        $this->form_validation->set_rules('img_name', '', 'callback_checkimgurl');
        if ($this->form_validation->run() == FALSE)
        {
            echo "<script type='text/javascript'>
            alert('Please Enter Image URL');
            </script>";
            $this->load->view('image_view');
        } 
        else
        {
            $data['data_image'] = convertToBase64($URL);
            $this->load->view('image_view', $data);
        }
    }

    // Check image format, if input image is valid return TRUE else returned FALSE.
    function checkimgurl($img) 
    {
        if (preg_match_all('!http://.+\.(?:jpe?g|png|gif)!Ui', $img)) 
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}
?>