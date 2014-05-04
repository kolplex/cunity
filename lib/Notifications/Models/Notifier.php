<?php

namespace Notifications\Models;

class Notifier {

    static private $instance = null;
    private $db = null;
    private $settings = null;
    private $types = null;
    private $mailView = null;

    static public function getInstance() {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    public static function notify($receiver, $sender, $type, $target, $ways = ["alert", "mail"]) {
        if (is_array($receiver)) {
            foreach ($receiver AS $user)
                self::notify($user['userid'], $sender, $type, $target, $ways);
        } else {
            $obj = self::getInstance();
            $st = $obj->settings->getSetting($type, $receiver);
            if (($st == 1 || $st == 3) && in_array("alert", $ways)) {
                $obj->db->insertNotification([
                    "userid" => $receiver,
                    "ref_userid" => $sender,
                    "type" => $type,
                    "target" => $target
                ]);
            }
            if (($st == 2 || $st == 3) && in_array("mail", $ways)) {
                $receiverData = $_SESSION['user']->getTable()->get($receiver);
                $online = new \DateTime($receiverData['lastAction']);
                $now = new \DateTime();
                $diff = $now->diff($online, true);
                if ($diff->i > 3) {
                    $notificationData = self::getNotificationData($type);
                    new \Notifications\View\NotificationMail(["email" => $receiverData->email, "name" => $receiverData->name], ["message" => \sprintf($notificationData, $_SESSION['user']->name), "target" => $target]);
                }
            }
        }
    }

    public function __construct() {
        $this->db = new Db\Table\Notifications();
        $this->settings = new Db\Table\Notification_Settings();
        $data = new \Zend_Config_Xml("Notifications/lang/types.xml");
        $this->types = $data->types;
    }

    public static function getNotificationData($type) {
        $obj = self::getInstance();
        $temp = $obj->types->toArray();
        return $temp[$type];
    }

}
