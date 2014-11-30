<?php
/**
*
* Auto Groups extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb\autogroups\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\autogroups\conditions\manager */
	protected $manager;

	/**
	* Constructor
	*
	* @param \phpbb\autogroups\conditions\manager $manager     Auto groups condition manager object
	* @return \phpbb\autogroups\event\listener
	* @access public
	*/
	public function __construct(\phpbb\autogroups\conditions\manager $manager)
	{
		$this->manager = $manager;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			// Auto Groups "Posts" listeners
			'core.submit_post_end'		=> 'check_posts_submit',
			'core.delete_posts_after'	=> 'check_posts_delete',
		);
	}

	/**
	* Check user's post count after submitting a post for auto groups
	*
	* @return null
	* @access public
	*/
	public function check_posts_submit()
	{
		$this->manager->check_condition('phpbb.autogroups.type.posts');
	}

	/**
	* Check user's post count after deleting a post for auto groups
	*
	* @return null
	* @access public
	*/
	public function check_posts_delete($event)
	{
		$this->manager->check_condition('phpbb.autogroups.type.posts', array(
			'action'	=> 'delete',
			'users'		=> $event['poster_ids'],
		));
	}
}
