<?php
/**
 * Redirect to external
 *
 * @author emanuele
 * @license   BSD http://opensource.org/licenses/BSD-3-Clause
 *
 * @version 0.0.1
 */

function template_show_redirect()
{
	global $context, $txt;

	echo '
	<h2 class="category_header">', $txt['redirect_title'], '</h2>
	<div style="text-align: center;" class="content">', $context['redirect_message'], '</div>';
}