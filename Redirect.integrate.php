<?php
/**
 * Redirect to external
 *
 * @author emanuele
 * @license   BSD http://opensource.org/licenses/BSD-3-Clause
 *
 * @version 0.0.1
 */

class Redirect_Integrate
{
	public static function redirect(&$setLocation, &$refresh)
	{
		if (self::agreeRedirect($setLocation, time() - 60))
			return;
		else
			return self::setTemporaryRedirect($setLocation, $refresh);
	}

	protected static function setTemporaryRedirect(&$setLocation, $refresh)
	{
		global $scripturl;

		$setLocation = $scripturl . '?action=redirect;url=' . urlencode($setLocation);
	}

	protected static function agreeRedirect($location, $cache_time)
	{
		global $boardurl;

		// Within the same domain is always fine.
		if (substr($setLocation, 0, strlen($boardurl)) === $boardurl)
			return true;

		// Already agreed "recently", fine as well
		if (isset($_SESSION[md5($location)]) && $_SESSION[md5($location)] > $cache_time)
			return true;

		// Any other case, not fine.
		return false;
	}
}