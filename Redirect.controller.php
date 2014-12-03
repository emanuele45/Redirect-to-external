<?php
/**
 * Redirect to external
 *
 * @author emanuele
 * @license   BSD http://opensource.org/licenses/BSD-3-Clause
 *
 * @version 0.0.1
 */

class Redirect_Controller extends Action_Controller
{
	protected $_decoded = '';

	public function action_index()
	{
		global $context, $modSettings, $txt, $scripturl;

		if (empty($_REQUEST['url']))
			redirectexit();

		loadLanguage('Redirect');
		loadTemplate('Redirect');
		$this->_decoded = urldecode($_REQUEST['url']);
		$modSettings['time_redirect'] = 15;

		$context['redirect_message'] = $this->_replace($txt['redirect_message']);
		$context['redirect_title_message'] = $this->_replace($txt['redirect_title_message']);

		$context['sub_template'] = 'show_redirect';
		$context['page_title'] = $txt['redirect_title'];
		addInlineJavascript('
		var countdown = ' . ($modSettings['time_redirect']) . ';

		var counter=setInterval(decreaseCounter, 1000);

		function decreaseCounter()
		{
			countdown--;
			if (countdown <= 0)
			{
				clearInterval(counter);
				window.location = ' . JavaScriptEscape($scripturl . '?action=redirect;sa=go;url='. $_REQUEST['url'])  . '
				return;
			}

			document.getElementById("redirecttime").innerHTML = countdown;
		}', true);
	}

	public function action_go()
	{
		$this->_decoded = urldecode($_REQUEST['url']);
		$_SESSION[md5($this->_decoded)] = time();
		redirectexit($this->_decoded);
	}

	protected function _replace($text)
	{
		global $mbname, $scripturl, $modSettings;

		return str_replace(
			array('{destination_url}', '{forum_name}', '{back_link}', '{time_redirect}'),
			array(Util::htmlspecialchars($this->_decoded), $mbname, '<a href="' . $scripturl . '">' . $scripturl . '</a>', '<span id="redirecttime">' . $modSettings['time_redirect'] . '</span>'),
			$text
		);
	}
}