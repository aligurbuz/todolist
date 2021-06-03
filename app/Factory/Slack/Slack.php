<?php

declare(strict_types=1);

namespace App\Factory\Slack;

use App\Jobs\SlackPusher;
use App\Factory\Slack\Interfaces\SlackInterface;

/**
 * Class Slack
 * @package App\Factory\Slack
 */
class Slack extends SlackManager implements SlackInterface
{
	/**
	 * binds property variable
	 *
	 * @var array
	 */
	protected array $binds = [];

    /**
     * @var array|string[]
     */
	protected array $resource = ['html'];

	/**
	 * Slack constructor
	 *
	 * @param array $binds
	 */
	public function __construct(array $binds = [])
	{
		$this->binds = $binds;
	}

    /**
     * get error internal error slack pusher
     *
     * @return void
     */
	public function getError500() : void
    {
        // we will push all 500 internal errors for the system to the slack channel.
        // The job that works on all slack messages is the SlackPusher class.
        $this->getError500ForResourceHtml(function($pusher){
            dispatch(new SlackPusher('logger',$pusher));
        });
    }
}
