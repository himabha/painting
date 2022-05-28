<?php

class Helper
{
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function getHebrewText($code)
    {
        $results = $this->wpdb->get_results("select lang_hb from translations where code = '".addslashes($code)."' and active = 1");
        if (empty($results)) {
            return "";
        }

        $row = $results;
        return $row[0]->lang_hb;
    }
}
