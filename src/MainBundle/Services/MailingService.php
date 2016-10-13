<?php
namespace MainBundle\Services;

class MailingService
{
    private $yourAdress;
    
    public function __construct ($yourAdress)
    {
        $this->yourAdress = $yourAdress;
    }
    
    public function sendMail ($mail, $object, $messageHtml) 
    {
        $yourAdress = $this->yourAdress;
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) 
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }
       
        //=====
        $boundary = "-----=".md5(rand());
        //==========
 
        //=====
        $header = "From: '.$yourAdress.'".$passage_ligne;
        $header.= "Reply-to: ".$yourAdress."\"".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"".$boundary."\"".$passage_ligne;
        //==========
 
        //=====
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        //=====
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$messageHtml.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
  
        //=====
        return mail($adresse,$object,$message,$header);
    }
}