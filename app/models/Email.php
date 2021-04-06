<?php

class Email {
    private $db;

    // Connect to the Database class
    public function __construct() {
        $this->db = new Database;
    }

    public function delete($id) {
            $this->db->query('SELECT provider_id FROM emails WHERE id=:id');

            // Bind values
            $this->db->bind(':id', $id);

            $provider_id = $this->db->single()->provider_id;

            $this->db->query('SELECT * FROM emails WHERE provider_id=:id');

            // Bind values
            $this->db->bind(':id', $provider_id);

            // Check if got any results
            if (!count($this->db->resultSet()) > 0) {
                $this->db->query('DELETE FROM providers WHERE id=:id');

                // Bind values
                $this->db->bind(':id', $provider_id);

                $this->db->execute();
            }
        
            $this->db->query('DELETE FROM emails WHERE id=:id');

            // Bind values
            $this->db->bind(':id', $id);

            $this->db->execute();
    }

    public function getExportData($id) {
        $this->db->query('SELECT * FROM emails WHERE id=:id');

        // Bind values
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function getEmailsUnsorted($provider, $search) {
        $this->db->query("SELECT * FROM emails
        WHERE email LIKE '%@" . $provider . ".%'
        AND email LIKE '%" . $search . "%'");

        return $this->db->resultSet();
    }

    public function getEmails($provider, $search, $order, $sort, $start, $rec_per_page) {
        $this->db->query("SELECT * FROM emails
        WHERE email LIKE '%@" . $provider . ".%'
        AND email LIKE '%" . $search . "%'
        ORDER BY " . $order . " " . $sort . " 
        LIMIT " . $start . ", ". $rec_per_page);

        return $this->db->resultSet();
    }

    public function getProviders() {
        $this->db->query("SELECT provider FROM providers");

        return $this->db->resultSet();
    }

    // Insert data
    public function insert($data) {
        $provider = $this->providerFromEmail($data['email']);
        
        if (!$this->findProvider($provider)) {
            $this->db->query('INSERT INTO providers (provider) VALUES (:provider)');

            // Bind values
            $this->db->bind(':provider', $provider);

            if (!$this->db->execute()) {
                return false;
            }
        }

        $provider_id = $this->getProviderId($provider);

        $this->db->query('INSERT INTO emails (provider_id, email) VALUES (:provider_id, :email)');

        // Bind values
        $this->db->bind(':provider_id', $provider_id);
        $this->db->bind(':email', $data['email']);

        if ($this->db->execute()) {
            return true;
        }
        else {
            return false;
        }
    }

    // Check if email already in database
    public function findEmail($email) {
        // Prepare query statement
        $this->db->query('SELECT * FROM emails WHERE email = :email');

        // Bind :email with the variable
        $this->db->bind(':email', $email);

        // Check if got any results
        if (count($this->db->resultSet()) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    // Check if provider already in database
    public function findProvider($provider) {
        // Prepare query statement
        $this->db->query('SELECT * FROM providers WHERE provider = :provider');

        // Bind :email with the variable
        $this->db->bind(':provider', $provider);

        // Check if got any results
        if (count($this->db->resultSet()) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getProviderId($provider) {
        $this->db->query('SELECT * FROM providers WHERE provider = :provider');

        //Bind value
        $this->db->bind(':provider', $provider);

        $row = $this->db->single();

        return $row->id;
    }

    // Check if provider already in database
    public function providerFromEmail($email) {

        $start = strpos($email, '@') +1;

        $provider_name = substr($email, $start);

        $end = strrpos($provider_name, '.');

        $provider_name = substr($provider_name, 0, $end);

        return $provider_name;
    }
}