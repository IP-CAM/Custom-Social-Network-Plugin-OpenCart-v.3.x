<?php
/**
 * Created by CodeDoctor Team.
 * User: nilge
 * Date: 23-06-19
 * Time: 05:52 AM
 * Project: ddc_shirdharth
 * Copyright: CodeDoctor Team (https://codedoctor.co.in)
 * License: This product/codes is/are property of Oxentic Technologies India Pvt. Ltd. Oxentic Technologies India Pvt. Ltd. or any other developers who have permission by Oxentic Technologies India Pvt. Ltd. has right to distribute or modify this code.
 */
Class ModelExtensionModuleNiladrisocialmedia extends Model
{
    public static $social_links;

    /*public function __get($name)
    {
        if (!self::$social_links)
        {
            self::$social_links = $this->getSocialNetworks();
        }
        if (!empty(self::$social_links[$name]) && !empty(self::$social_links[$name]['link']))
        {
            return self::$social_links[$name]['link'];
        }
        return null;
    }*/

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
}