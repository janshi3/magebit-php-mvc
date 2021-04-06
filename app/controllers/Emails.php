<?php

class Emails extends Controller {
    // Connect to the email model
    public function __construct() {
        $this->emailModel = $this->model('Email');
    }

    // Display the table
    public function index() {

        // Records per page
        $rec_per_page = 10;

        $data = [
            'page' => '1',
            'order' => 'email',
            'sort' => '1',
            'provider' => '%',
            'search' => '',
            'all_providers' => [],
            'emails' => [],
            'result_count' => '',
            'total_pages' => ''
        ];

        // Get all GET values
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $data['page'] = $_GET['page'];
        }

        if (isset($_GET['order'])) {
            $data['order'] = $_GET['order'];
        }

        if (isset($_GET['sort'])) {
            $data['sort'] = $_GET['sort'];
        }

        if (isset($_GET['provider'])) {
            $data['provider'] = $_GET['provider'];
        }

        if (isset($_GET['search'])) {
            $data['search'] = $_GET['search'];
        }

        // Calculate first record index
        if ($data['page'] > 1) {
            $start = ($data['page'] * $rec_per_page) - $rec_per_page;
        } else {
            $start = 0;
        }

        // Get result count
        $data['result_count'] = count($this->emailModel->getEmailsUnsorted($data['provider'], $data['search']));

        // Get page count
        $data['total_pages'] = ceil($data['result_count'] / $rec_per_page);

        // Change sort from bool to ASC / DESC
        $data['sort'] == true ? $sort = 'ASC' : $sort = 'DESC';

        // Get records to display
        $data['emails'] = $this->emailModel->getEmails($data['provider'], $data['search'], $data['order'], $sort, $start, $rec_per_page);

        // Get all providers
        $providerObject = $this->emailModel->getProviders();

        // Push providers into an array
        foreach ($providerObject as $provider) {
            array_push($data['all_providers'], $provider->provider);
        }

        // Display the view with data
        $this->view('table', $data);
    }

    // Delete or export emails
    public function deleteOrExport() {

        // If delete is clicked
        if (isset($_POST['delete'])) {

            // Get selected emails
            $selected = $_POST['select'];
        
            // Delete selected emails
            foreach($selected as $id) {
                $this->emailModel->delete($id);
            }

            // Redirect to table page
            header('location: http://localhost/emails');
        }

        // If export is clicked
        elseif (isset($_POST['export'])) {

            // Get selected emails
            $selected = $_POST['select'];

            // Create an array for csv data
            $csvData = [];

            // Add table headers
            array_push($csvData, array(
                'Id',
                'Email',
                'Date'
            ));
        
            // Get all selected email data
            foreach($selected as $id) {
                $email = $this->emailModel->getExportData($id);

                // Push each email data into csv data array
                array_push($csvData, array(
                    $email->id,
                    $email->email,
                    $email->date
                ));
            }

            // Convert the csv data array into a .csv file, set the name to current time and download the file
            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($csvData);
        }
    }
    
    // Download a file
    private function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
    
        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
    
        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
    
    // Convert an array To a ".csv" file
    private function array2csv(array &$array)
    {
        // Check If Array Is Not Empty
    
       if (count($array) == 0) {
         return null;
       }
    
        // Write Array Contents To The ".csv" File
    
       ob_start();
       $df = fopen("php://output", 'w');
       foreach ($array as $row) {
          fputcsv($df, $row);
       }
       fclose($df);
       return ob_get_clean();
    }

    // Check if a string ends wIth a certain group of characters
    private function endsWith($string, $term) {
        return substr_compare($string, $term, -strlen($term)) === 0;
    }

    // Validate and submit email
    public function submit() {
        $data = [
            'email' => '',
            'terms' => '',
            'emailError' => '',
            'termsError' => ''
        ];

        // Check if POST method is used
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'terms' => ''
            ];

            // Check if terms are checked
            if (isset($_POST['terms'])) {
                $data['terms'] = $_POST['terms'];
            }
            else {
                $data['terms'] = false;
            }

            // Validate email

            // Check if empty
            if (empty($data['email'])) {
                $data['emailError'] = 'Email address is required';
            }

            // Check if valid format
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = 'Please provide a valid e-mail address';
            }

            // Check if ends with .co
            elseif ($this->endsWith($data['email'], '.co')) {
                $data['emailError'] = 'We are not accepting subscriptions from Colombia emails';
            }

            else {

                // Check if already exists
                if ($this->emailModel->findEmail($data['email'])) {
                    $data['emailError'] = 'Email already submitted';
                }
            }

            // Validate terms
            if (!filter_var($data['terms'], FILTER_VALIDATE_BOOLEAN)) {
                $data['termsError'] = 'You must accept the terms and conditions';
            }

            // If there's no errors, insert email into the database
            if (empty($data['emailError']) && empty($data['termsError'])) {
                if ($this->emailModel->insert($data)){

                    // Redirect to success page
                    header('location: http://localhost/pages/success');
                }
                else {
                    // Oops
                    die('Something went wrong D:');
                }
                
            }
        }

        // Return to index page with data
        $this->view('index', $data);
    }
}