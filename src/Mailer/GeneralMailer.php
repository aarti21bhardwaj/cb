<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Log\Log;

class GeneralMailer extends Mailer
{
    public function sendMail($data)
    {
      // pr('here in mailer');die;

      // pr($data);die;
       $hashData= $data['hashData'];
       $event = $data['event'];
       $email = $event['emails'][0];
       // pr($event);die;
      Log::write('debug', json_encode($data));
       // pr($hashData);die;
       $content = $this->substitute($email['body'], $hashData);
       $subject = $this->substitute($email['subject'], $hashData);
       // $email['from_email'] = 'vivek.bharti@twinspark.co';
       // pr($email);die; 
       $this->setSubject($subject)
            ->setTemplate('default')
            ->setLayout('default')
            ->setEmailFormat('html')
            ->set('content', $content);

        //Check if from email is set in email settings
        if(isset($email['from_email']) && $email['from_email']){
          if(isset($email['from_name'])){
            $this->setFrom([$email['from_email'] => $email['from_name']]);
          }else{
            $this->setFrom($email['from_email']);
          }
        }


        //Check if recipient's email is set in hash data
        if(isset($hashData['email']) && $hashData['email']){

          // pr($hashData['email']);die;
          $this->setTo($hashData['email']);
        }

        //Check if any cc is set in hash data
        if(isset($hashData['cc']) && $hashData['cc']){
          $this->setCc($hashData['cc']);
        }

        //Check if any bcc is set in hash data
        if(isset($hashData['bcc']) && $hashData['bcc']){
          $this->setBcc($hashData['bcc']);
        }

        //Check if any recipients's are set in email settings.
        if(isset($email['recipients']) && $email['recipients']){
          $recipients = explode(',', $email['recipients']);
          foreach ($recipients as $key => $value) {
            $recipients[$key] = trim($value);
          }
          $this->addBcc($recipients);
        }        
    }
    public function substitute($content, $hash){
       
        $i=0;
        foreach ($hash as $key => $value) {
            if(!is_array($value)){
                $placeholder = sprintf('{{%s}}', $key);
                if($placeholder=="{{".$key."}}"){
                    if(!$i){
                        $afterStr = str_replace($placeholder, $value, $content);
                    }else{
                        $afterStr = str_replace($placeholder, $value, $afterStr);
                    }
                    $i++;
                }
            }
        }
        return $afterStr;
    }
   
}
?>