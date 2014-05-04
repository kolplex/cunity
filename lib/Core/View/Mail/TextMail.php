<?php

namespace Core\View\Mail;

class TextMail extends MailView {

    protected $templateDir = "core";
    protected $templateFile = "textmail.tpl";

    public function __construct($receiver, array $text) {
        parent::__construct();
        if((!isset($receiver['name']) || !isset($receiver['email'])) && isset($receiver['userid'])){
            $user = $_SESSION['user']->getTable()->search("userid",$receiver['userid']);
            if($user !== NULL){
                $receiver['name'] = $user->name;
                $receiver['email'] = $user->email;
            }
        }                       

        $this->_receiver = $receiver;
        $this->_subject = $this->translate($text['subject']['text'], $text['subject']['replaces']);
        $this->assign("name", $receiver["name"]);
        if (isset($text['content']))
            $this->assign("content", $this->translate($text['content']['text'], $text['content']['replaces']));
        else
            $this->assign("content", $this->translate($text['subject']['text'], $text['subject']['replaces']));
        $this->show();
    }

}
