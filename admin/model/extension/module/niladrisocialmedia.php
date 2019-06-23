<?php
/**
 * Created by CodeDoctor Team.
 * User: nilge
 * Date: 14-06-19
 * Time: 09:19 AM
 * Project: ddc_shirdharth
 * Copyright: CodeDoctor Team (https://codedoctor.co.in)
 * License: This product/codes is/are property of Oxentic Technologies India Pvt. Ltd. Oxentic Technologies India Pvt. Ltd. or any other developers who have permission by Oxentic Technologies India Pvt. Ltd. has right to distribute or modify this code.
 */

class ModelExtensionModuleniladrisocialmedia extends Model
{
    public function createSocialMediaTable()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `". DB_PREFIX ."nil_social_network` ( 
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,  
                `name` VARCHAR(100) NOT NULL ,  
                `link` TEXT NOT NULL ,    
                PRIMARY KEY  (`id`),    
                UNIQUE  (`name`)
            ) DEFAULT COLLATE=utf8_general_ci;;
        ");
    }

    public function deleteSocialMediaTable()
    {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "nil_social_network`");
    }

    public function addSocialNetwork($name, $link)
    {
        try {
            if ($this->checkSocialNetworkExists($name) > 0)
            {
                throw new \Exception('Social network already exists');
            }
            $sql = "INSERT INTO `". DB_PREFIX ."nil_social_network` (`name`, `link`) VALUES('{$name}', '{$link}')";
            $this->db->query($sql);
            return $this->db->getLastId();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    public function editSocialNetwork($id, $name, $link)
    {
        try {
            if ($this->checkSocialNetworkExists($name) <= 0)
            {
                throw new \Exception('Invalid social network selected to edit');

            }
            $sql = "UPDATE `". DB_PREFIX ."nil_social_network` SET `name`='{$name}', `link`='{$link}' WHERE `id`='{$id}'";

            $this->db->query($sql);
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function groupInsertOrUpdateSocialNetwork()
    {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['social']))
        {
            foreach ($this->request->post['social'] as $name => $value)
            {
                $sql = "INSERT INTO `". DB_PREFIX ."nil_social_network`(`name`,`link`) VALUES ('{$name}', '{$value}') ON DUPLICATE KEY UPDATE `link`='{$value}'";
                $this->db->query($sql);
            }
            return true;
        }
        return false;
    }

    public function getSocialNetworks()
    {
        $sql = "SELECT * FROM `". DB_PREFIX ."nil_social_network` WHERE 1";
        $query = $this->db->query($sql);
        $rows = $query->rows;

        $social_networks = array();

        if (!empty($rows) && is_array($rows))
        {
            foreach ($rows as $row)
            {
                $social_networks[$row['name']] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'link' => $row['link'],
                ];
            }
        }

        return $social_networks;
    }

    protected function checkSocialNetworkExists($social_network_name)
    {
        try {
            $query = $this->db->query("SELECT COUNT(*) AS `aggregate` FROM `". DB_PREFIX ."nil_social_network` WHERE `name`='{$social_network_name}'");
            $rows = $query->rows;
            $aggregate = 0;
            foreach ($rows as $row)
            {
                $aggregate = $row['aggregate'];
            }
            return $aggregate;
        } catch (\Exception $exception) {
            return 0;
        }
    }
}