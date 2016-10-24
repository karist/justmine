<?php


namespace App\Listeners;


use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\App;
use Krowinski\LaravelXSLT\Events\XSLTEngineEvent;

/**
* Class XSLTDebugBar
* @package App\Listeners
*/
class XSLTDebugBar
{
   /**
    * @param XSLTEngineEvent $event
    */
   public function handle(XSLTEngineEvent $event)
   {
       $dom = new \DOMDocument;
       $dom->preserveWhiteSpace = false;
       $dom->loadXML($event->getExtendedSimpleXMLElement()->saveXML());
       $dom->formatOutput = true;
       $xml_string = $dom->saveXML();

       /** @var DebugBar $debugBar */
       $debugBar = App::make('debugbar');
       if (false === $debugBar->hasCollector('XML'))
       {
           $debugBar->addCollector(new MessagesCollector('XML'));
       }
       /** @var MessagesCollector $collector */
       $collector = $debugBar->getCollector('XML');
       $collector->addMessage($xml_string, 'info', false);
   }
}