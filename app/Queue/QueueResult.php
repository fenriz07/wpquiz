<?php namespace App\Queue;

use WP_Background_Process;
use App\Repository\ResultRepository;


class QueueResult extends WP_Background_Process {

	/**
	 * @var string
	 */
	protected $action = 'task_register_result';

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
    protected function task( $item ) 
    {
        ( new ResultRepository() )->store( $item );
        
		return false;
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();

		// Show notice to user or perform some other arbitrary task...
	}

}