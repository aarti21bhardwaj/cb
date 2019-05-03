<?php 
use App\Event\MailerEventListener;
use Cake\Event\EventManager;


$mailerEventListener = new MailerEventListener();
EventManager::instance()->on($mailerEventListener);
?>