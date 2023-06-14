<?php

class Alert
{

    static function OpenAlert($message)
    {
        echo "<script>alert(`$message`); window.setTimeout(function() {
                    window.location.href = 'login.php';
                    }, 0);</script>";
    }
}
