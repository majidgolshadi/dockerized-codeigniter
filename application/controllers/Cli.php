<?php

class Cli extends CI_Controller
{

    public function migration($version)
    {
        $this->load->library('migration');

        if($this->input->is_cli_request())
        {
            $migration = $this->migration->version($version);

            if (!$migration) {
                echo $this->migration->error_string();
            } else {
                echo 'Migration(s) done'.PHP_EOL;
            }

        } else {
            show_error('You don\'t have permission for this action');;
        }
    }

}
