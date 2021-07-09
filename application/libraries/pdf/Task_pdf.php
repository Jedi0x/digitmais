<?php
// Junaid code here
defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Task_pdf extends App_pdf
{
    protected $task_ids;

    private $tasks;

    public function __construct($task_ids, $tag = '')
    {
        //$this->load_language($task->project_data->client_data->userid);
        $task_ids                = hooks()->apply_filters('task_html_pdf_data', $task_ids);
        $GLOBALS['task_pdf'] = $task_ids;

        parent::__construct();

        if (!class_exists('tasks_model', false)) {
            $this->ci->load->model('tasks_model');
        }

        $this->tag          = $tag;
        $this->task_ids        = $task_ids;

        $this->SetTitle('Tasks');
    }

    public function prepare()
    {
        // $this->with_number_to_word($this->task->clientid);

        $this->set_view_vars([
            'status'         => 1,
            'tasks' => array(),
            'payment_modes'  =>  array(),
            'task_ids'        =>  $this->task_ids,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'task';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/my_taskpdf.php';
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/taskpdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }

    
}
