<?php
namespace vendor\ASh\Session;

use abstracts\Base;

class PushNotify extends Base
{
    /**
     * @param type $message
     */
    public function send($message = null, $type = null)
    {
        $message = is_string($message) ? $message : null;
        if ($message !== null) {
            $_SESSION['_message_notify'] = $message;
            
            switch ($type) {
                case 'success':
                case 'error':
                    break;
                
                default:
                    $type = 'info';
                    break;
            }
            $_SESSION['_type_notify'] = $type;
        }
    }

    public function accept()
    {
        if (isset($_SESSION['_message_notify'])) {
            $type = isset($_SESSION['_type_notify']) ? $_SESSION['_type_notify'] : null;
            switch ($type) {
                case 'success':
                    $class = 'border-primary text-primary';
                    break;
                
                case 'error':
                    $class = 'border-danger text-danger';
                    break;
                
                default:
                    $class = 'border-secondary text-secondary';
                    break;
            }
            
            echo "<p class='p-3 border {$class}'>{$_SESSION['_message_notify']}</p>";
            unset($_SESSION['_message_notify']);
            
            if (isset($_SESSION['_type_notify'])) {
                unset($_SESSION['_type_notify']);
            }
        }
    }
}