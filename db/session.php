<?php
require '../db/database.php';

$db = new Database();

class Session {
    public static function setHandler()
    {
        session_set_save_handler(
            array('session', 'open'),
            array('session', 'close'),
            array('session', 'read'),
            array('session', 'write'),
            array('session', 'destroy'),
            array('session', 'garbageCollection')
        );
    }

    public static function open($save_path, $session_name)
    {
        return true;
    }

    public static function close()
    {
        return true;
    }

    public static function read($session_id)
    {
        global $db;

        $query = $db->query(
            "SELECT `session_data`
               FROM `sessions`
              WHERE `session_id` = '{$session_id}'
              LIMIT 1"
        );

        return(
            ($query->rowCount())?
                stripslashes($query->fetch(PDO::FETCH_ASSOC["session_data"]))
            :
                null
        );
    }

    public static function write($session_id, $session_data)
    {
        global $db;

        $query = $db->query("SELECT * FROM `sessions` WHERE `session_id` = '{$session_id}'");

        if ($query->rowCount())
        {
            $db->query(
                "UPDATE `sessions`
                    SET `session_data`  = '".addslashes($session_data)."',
                        `last_accessed` = NOW()
                  WHERE `session_id`    = '{$session_id}'"
            );
        }
        else
        {
            $db->query(
                "INSERT
                   INTO `sessions`
                 VALUES (
                     '{$session_id}',
                     '".addslashes($session_data)."',
                     NOW()
                 )"
            );
        }
    }

    public static function destroy($session_id)
    {
        global $db;

        $db->query(
            "DELETE
               FROM `sessions`
              WHERE `session_id` = '{$session_id}'"
        );
    }

    public static function garbageCollection($lifetime)
    {
        global $db;

        $db->query(
            "DELETE
               FROM `sessions`
              WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`last_accessed`) > {$lifetime}"
        );
    }

    public static function name()
    {
        return session_name();
    }

    public static function id()
    {
        return session_id();
    }
}
