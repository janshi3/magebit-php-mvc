<?php

class Email {
    private $db;

    // Connect to the Database class
    public function __construct() {
        $this->db = new Database;
    }

    // Delete emails and providers
    public function delete($id) {

            // Get provider id
            $this->db->query('SELECT provider_id FROM emails WHERE id=:id');
            $this->db->bind(':id', $id);
            $provider_id = $this->db->single()->provider_id;

            // Search for emails with the same provider
            $this->db->query('SELECT * FROM emails WHERE provider_id=:id');
            $this->db->bind(':id', $provider_id);

            // Check if got any results
            if (!count($this->db->resultSet()) > 0) {

                // If provider has no other emails, then delete the provider
                $this->db->query('DELETE FROM providers WHERE id=:id');
                $this->db->bind(':id', $provider_id);
                $this->db->execute();
            }
        
            // Delete the email
            $this->db->query('DELETE FROM emails WHERE id=:id');
            $this->db->bind(':id', $id);
            $this->db->execute();
    }

    // Get an email from id
    public function getExportData($id) {
        $this->db->query('SELECT * FROM emails WHERE id=:id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }

    // Get a filtered unsorted email list
    public function getEmailsUnsorted($provider, $search) {
        $this->db->query("SELECT * FROM emails
        WHERE email LIKE '%@" . $provider . ".%'
        AND email LIKE '%" . $search . "%'");

        return $this->db->resultSet();
    }

    // Get a filtered and sorted email list
    public function getEmails($provider, $search, $order, $sort, $start, $rec_per_page) {
        $this->db->query("SELECT * FROM emails
        WHERE email LIKE '%@" . $provider . ".%'
        AND email LIKE '%" . $search . "%'
        ORDER BY " . $order . " " . $sort . " 
        LIMIT " . $start . ", ". $rec_per_page);

        return $this->db->resultSet();
    }

    // Get all provider names
    public function getProviders() {
        $this->db->query("SELECT provider FROM providers");

        return $this->db->resultSet();
    }

    // Insert data
    public function insert($data) {

        // Get the provider name from the email
        $provider = $this->providerFromEmail($data['email']);
        
        // Check if the provider is in the database
        if (!$this->findProvider($provider)) {

            // If not, add provider to database
            $this->db->query('INSERT INTO providers (provider) VALUES (:provider)');
            $this->db->bind(':provider', $provider);
            if (!$this->db->execute()) {
                return false;
            }
        }

        // Get provider id
        $provider_id = $this->getProviderId($provider);

        // Insert email into database with provider id as foreign key
        $this->db->query('INSERT INTO emails (provider_id, email) VALUES (:provider_id, :email)');
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

        // Get the email from database
        $this->db->query('SELECT * FROM emails WHERE email = :email');
        $this->db->bind(':email', $email);

        // Return true if found any results
        if (count($this->db->resultSet()) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    // Check if provider already in database
    public function findProvider($provider) {

        // Get the provider from database
        $this->db->query('SELECT * FROM providers WHERE provider = :provider');
        $this->db->bind(':provider', $provider);

        // Return true if found any results
        if (count($this->db->resultSet()) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    // Get provider id from provider name
    public function getProviderId($provider) {

        // Get provider
        $this->db->query('SELECT * FROM providers WHERE provider = :provider');
        $this->db->bind(':provider', $provider);

        // Extract and return id
        $row = $this->db->single();
        return $row->id;
    }

    // Get provider name from an email
    public function providerFromEmail($email) {

        // Start from the @
        $start = strpos($email, '@') +1;

        // Cut out the part before @
        $provider_name = substr($email, $start);

        // End with the . after @
        $end = strrpos($provider_name, '.');

        // Get the provider name between @ and .
        $provider_name = substr($provider_name, 0, $end);

        return $provider_name;
    }
}