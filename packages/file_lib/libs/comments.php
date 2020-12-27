<?php
/**
 * @author           Denys Nosov, web@denysdesign.com / http://denysdesign.com
 * @copyright        2018-2019 (C) EVOLVENS, https://evolvens.net. All rights reserved.
 * @copyright        2018-2019 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          commerce
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Static class to handle loading of libraries.
 *
 * @package          Joomla.Site
 * @subpackage       seblod
 * @since            1.5
 */
class Comments
{
	/**
	 * @param string $id
	 *
	 * @return \JDatabaseDriver|string
	 *
	 * @throws \Exception
	 * @since 1.5
	 */
	public function count($id = '')
	{
		if(!$id)
		{
			return '-1';
		}

		$db = Factory::getDBO();
		$qc = $db->getQuery(true);
		$qc->select('count(id)');
		$qc->from('#__cck_store_form_comments');
		$qc->where('comments_article_id = ' . (int) $id);
		$db->setQuery($qc);

		return $db->loadResult();
	}

	/**
	 * @param $config
	 * @param $fields
	 *
	 * @param $f_post
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 * @since 1.5
	 */
	public function email_comments($config, $fields, $f_post)
	{
		$app  = Factory::getApplication('site');
		$user = Factory::getUser($config[ 'author' ]);

		// params
		$id          = $config[ 'id' ];
		$comment_id  = $config[ 'pk' ];
		$parent_id   = $config[ 'post' ][ 'comments_parent_id' ];
		$article_url = $config[ 'post' ][ 'comments_article_url' ];
		$article_id  = $config[ 'post' ][ 'comments_article_id' ];
		$delete_link = JURI::base() . '/index.php?option=com_cck&amp;task=delete&amp;cid=' . $id . '&amp;return=' . base64_encode($article_url . '#comments');

		// comment body
		$name  = $fields[ $f_post ]->storage_field;
		$table = $fields[ $f_post ]->storage_table;
		$post  = $config[ 'storages' ][ $table ][ $name ];

		// connect DB
		$db = Factory::getDBO();

		// article title
		$qarticle = $db->getQuery(true);
		$qarticle->select('title');
		$qarticle->from('#__content');
		$qarticle->where('id = ' . (int) $article_id);
		$db->setQuery($qarticle);
		$article_title = $db->loadResult();

		if($parent_id)
		{
			// reply mail
			$qreply = $db->getQuery(true);
			$qreply->select([ 'author_id' ]);
			$qreply->from('#__cck_core');
			$qreply->where('pk = ' . $parent_id);
			$qreply->where('cck = \'comments\'');
			$db->setQuery($qreply);
			$r_user = $db->loadResult();

			// user
			$reply_user = Factory::getUser($r_user);

			// reply send mail
			$subject = 'Ответ на ваш комментарий в: «' . $article_title . '»';

			$body = '<p><strong>Здраствуйте, ' . $reply_user->name . '!</strong></p>';
			$body .= '<p>У вас появился ответ от ' . $user->name . ':<br>';
			$body .= '<blockquote style="margin:0px 0px 0px 0.8ex;border-left:3px solid rgb(204,204,204);padding-left:1ex">' . $post . '</blockquote>';
			$body .= '</p><p><a href="' . $article_url . '#comment-' . $comment_id . '" target="_blank">Ответить на сайте &raquo;&raquo;</a></p>';

			// send mail to reply user
			self::_send_mail($reply_user->email, $subject, $body);
		}

		// admin send mail
		$a_subject = '[admin] Новый комментарий в: «' . $article_title . '»';

		$a_body = '<p><strong>Привет, Админ!</strong></p>';
		$a_body .= '<p>Добавлен комментарий от ' . $user->name . ':<br>';
		$a_body .= '<blockquote style="margin:0;border-left:3px solid rgb(204,204,204);padding-left:1px">' . $post . '</blockquote>';
		$a_body .= '</p><p><a href="' . $article_url . '#comment-' . $comment_id . '" target="_blank">Ответить на сайте &raquo;&raquo;</a></p>';
		$a_body .= '<hr/><p>Если комментарий похож на СПАМ, то его можно удалить. Воспользуемся ссылкой ниже ;-)</p><p><a href="' . $delete_link . '" target="_blank">Удалить</a></p>';

		// send mail to admin
		self::_send_mail('denys@bad-android.com', $a_subject, $a_body);

		return true;
	}

	public static function _send_mail($recipient, $subject, $body)
	{
		$app         = Factory::getApplication('site');
		$senderEmail = $app->get('mailfrom');
		$senderName  = $app->get('fromname');

		$body .= '<br><br>--<br>&copy; ' . date('Y') . ' Bad Android';

		$mailer = JFactory::getMailer();
		$mailer->setSender([
			$senderEmail,
			$senderName
		]);

		$mailer->addRecipient($recipient);
		$mailer->setSubject($subject);
		$mailer->setBody($body);
		$mailer->IsHTML(true);

		return $mailer->Send();
	}
}