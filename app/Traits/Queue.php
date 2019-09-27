<?php namespace App\Traits;

trait Queue
{
   private $queueResult;

   public function initWorkers() 
   {
        global $queueResult;
        $this->queueResult = $queueResult;
   }

}
