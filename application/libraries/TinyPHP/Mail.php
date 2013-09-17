<?php
namespace Libraries\TinyPHP;
use \Swift_Message;
use \Swift_SmtpTransport;
use \Swift_Mailer;
use \Swift_Attachment;
class Mail
{
    private $recipients = array();
    private $from = '';
    private $type = 'text/html';
    private $subject;
    private $body;
    private $attachments = array();
    private static $_smtpHost;
    private static $_smtpPort;
    private static $_smtpUsername;
    private static $_smtpPassword;
    
    public function addRecipient($recipientEmail)
    {
        $this->recipients[] = $recipientEmail;
    }
    
    public function setFrom($fromEmail)
    {
        $this->from = $fromEmail;
    }
    
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }
    
    public function addAttachment($attachmentPath)
    {
        $this->attachments[] = $attachmentPath;
    }
    
    public function send()
    {
        $message = Swift_Message::newInstance($this->subject);
        $message->setFrom($this->from);
        if(empty($this->recipients)){
            throw new Exception("Please add at least 1 recipient!");
        }
        foreach($this->recipients as $recipientEmail){
            $message->addTo($recipientEmail);
        }
        if(!empty($this->attachments)){
            foreach($this->attachments as $attachmentPath){
                $message->attach(Swift_Attachment::fromPath($attachmentPath));
            }
        }
        $message->setBody($this->body,$this->type);
        
        // Smtp
        self::getSmtpCredentials();
        $transport = Swift_SmtpTransport::newInstance(self::$_smtpHost,self::$_smtpPort)->setUsername(self::$_smtpUsername)->setPassword(self::$_smtpPassword);
        $mailer = Swift_Mailer::newInstance($transport);
        $result = $mailer->send($message);
        return $result;
    }
    
    private static function getSmtpCredentials()
    {
        $config = Application::$config;
        self::$_smtpHost     = $config['smtpHost'];
        self::$_smtpPort     = $config['smtpPort'];
        self::$_smtpUsername = $config['smtpUsername'];
        self::$_smtpPassword = $config['smtpPassword'];
    }
}