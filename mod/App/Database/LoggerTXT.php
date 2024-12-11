<?php
namespace  Log;

class LoggerTXT extends Logger{

  public function write($message) {
      
       $text = date('Y-m-d H:i:s') . ' : ' . $message;
       $handler = fopen($this->filename, 'a');
       fwrite($handler, $text);
       fclose($handler);
  }




}