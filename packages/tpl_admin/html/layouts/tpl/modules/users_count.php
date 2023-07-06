<?php
/**
 * Seblod Admin Template
 *
 * @version       2.x
 * @package       admin
 * @author        Denys D. Nosov (denys@joomla-ua.org)
 * @copyright (C) 2018-2023 by Denys D. Nosov (https://joomla-ua.org)
 * @license       GNU General Public License version 2 or later; see LICENSE.md
 *
 **/

/** @var array $displayData */

use Joomla\CMS\Layout\FileLayout;

$data = (object) $displayData;

$users_count = '';
if($data->params->get('count_users', 0))
{
	$result      = [];
	$user_array  = 0;
	$guest_array = 0;

	$query = $data->db->getQuery(true);
	$query->select([ 'guest', 'client_id' ]);
	$query->from('#__session');
	$query->where('client_id = 0');
	$query->group('userid');
	$data->db->setQuery($query);

	try
	{
		$sessions = (array) $data->db->loadObjectList();
	}
	catch (RuntimeException $e)
	{
		$sessions = [];
	}

	if(count($sessions))
	{
		foreach($sessions as $session)
		{
			if($session->guest == 0)
			{
				$user_array++;
			}
		}
	}

	$result[ 'user' ] = $user_array;
	$users_count      = $result[ 'user' ];
}

?>
<?php if($data->params->get('count_users', 0)): ?>
	<ul class="uk-navbar-nav">
		<li class="uk-active uk-flex-middle">
			<a>
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'users',
					'size'  => 24,
					'class' => 'tm-margin-xsmall-right uk-text-primary'
				]);
				?>
				<span class="uk-text-middle uk-text-primary"><?php echo $users_count; ?></span>
			</a>
		</li>
	</ul>
<?php endif; ?>
