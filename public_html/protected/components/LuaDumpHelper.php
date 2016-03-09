<?php

/**
 * lua dump:
 * in debug: crypted and uncrypted
 * in release: crypted
 */
class LuaDumpHelper {

	/**
	 * Clear dump content, removing unused data and extra chars
	 * Remove all comments.
	 * Works with lua code.
	 */
	public static function getClearedContent($luaDumpContent)
	{
		if (empty($luaDumpContent))
			return false;

		$crypted = self::isCrypted($luaDumpContent);
		if ($crypted === null)
			return false;

		if ($crypted)
			$clearedContent = self::getPlayerDataFromCryptedDump($luaDumpContent);
		else
			$clearedContent = self::getPlayerDataFromDump($luaDumpContent);

		$clearedContent = self::removeExtraChars($clearedContent);

		return $clearedContent;
	}

	/**
	 * Retrieve player's data from lua dump,
	 * remove extra global variables.
	 *
	 * @todo do it
	 * 
	 * @param string $content
	 *
	 * @return string Player's dump
	 */
	private static function getPlayerDataFromDump($content)
	{
		$chdClientStartIndex = strpos($content, 'CHD_CLIENT');
		if ($chdClientStartIndex === false)
			return false;
		$dumpTableStartIndex = strpos($content, '{', $chdClientStartIndex);
		if ($dumpTableStartIndex === false)
			return false;

		// skip table
		// recursively find the end of table '}'
		// ...

		// cut dump table
		// ...

		return $content;
	}

	/**
	 * 
	 * @param string $luaDumpContent
	 * 
	 * @return string
	 */
	private static function getPlayerDataFromCryptedDump($luaDumpContent)
	{
		$chdClientStartIndex = strpos($luaDumpContent, 'CHD_CLIENT');
		if ($chdClientStartIndex === false)
			return false;

		$posDumpCryptStart = strpos($dumpLuaFileContent, '"', $chdClientStartIndex + 10);
		if ($posDumpCryptStart === false)
			return false;

		$posDumpCryptEnd = strpos($dumpLuaFileContent, '"', $posDumpCryptStart + 1);
		if ($posDumpCryptEnd === false)
			return false;

		return substr($luaDumpContent, $chdClientStartIndex, $posDumpCryptEnd - $chdClientStartIndex + 1);
	}

	/**
	 * Return crypt state
	 *
	 * uncrypted: CHD_CLIENT = { ... }
	 * crypted:   CHD_CLIENT = "dasdaskjakljsblkqwep..."
	 * 
	 * @return mixed
	 *         true, if dump is not crypted
	 *         false, if dump is crypted
	 *         null, if dump is corrupted
	 */
	public static function isCrypted($luaDumpContent)
	{
		$chdClientStartIndex = strpos($luaDumpContent, 'CHD_CLIENT');
		if ($chdClientStartIndex === false)
			return null;

		$chdClientStartIndex += 10; // strlen("CHD_CLIENT") == 10

		// go to first char after '='
		$len = strlen($luaDumpContent);
		$offset = $chdClientStartIndex;
		// skip spaces
		while ($offset < $len && $luaDumpContent[$offset] === ' ')
			++$offset;
		if ($offset === $len || $luaDumpContent[$offset] !== '=')
			return null;
		++$offset; // skip '='

		// skip spaces
		while ($offset < $len && $luaDumpContent[$offset] === ' ')
			++$offset;
		if ($offset === $len)
			return null;

		return $luaDumpContent[$offset] === '"';
	}

	/**
	 * Remove extra characters, such as
	 *  - whitespaces
	 *  - \t tabulars
	 *  - \r \n new lines
	 *  - ',' commas, only where need
	 */
	private static function removeExtraChars($content) {
		$len = strlen($content);
		$clearedContent = '';

		$i = 0;
		while ($i < $len) {
			$ch = $content[$i];
			if ($ch === '"') {
				$clearedContent .= self::skipString($content, $len, $i, '"');
				continue;
			}
			if ($ch === '\'') {
				$clearedContent .= self::skipString($content, $len, $i, '\'');
				continue;
			}
			/*
			// TODO: WoW don't use this strings
			if ($ch === '[') {
				if ($i + 1 < $len && $content[$i + 1] === '[') {
					
				}
			}*/

			while ($ch === ' ' || $ch === "\n" || $ch === "\t" || $ch === "\r") {
				++$i;
			}

			if ($ch === ',') {
				if ($i + 1 < $len && $content[$i + 1] === '}')
					++$i;
			}

			$clearedContent .= $ch;

			++$i;
		}
	}

	/**
	 * "content"
	 * |__ $offset to first char
	 *
	 * @param $content  Lua dump
	 * @param $len      Length of Lua dump
	 * @param $offset   Offset from start content
	 * @param $quote    " or '
	 *
	 * @return string String like "123" or '123'
	 */
	private static function skipString($content, $len, &$offset, $quote)
	{
		$s = (string)$quote;

		++$offset;
		while ($offset < $len)
		{
			$ch = $content[$offset];
			if ($ch === $quote) {
				// check \" or \'
				if ($offset > 0 && $content[$offset - 1] === '\\') {
					$slashCount = 0;
					$offsetSlash = $offset - 1;
					while ($offsetSlash && $content[$offsetSlash] === '\\') {
						++$slashCount;
						--$offsetSlash;
					}
					if ($offsetSlash % 2) {
						$s .= $quote;
						continue;
					}
				}

				$s .= $quote;
				++$offset;
				break;
			}

			$s .= $ch;
			++$offset;
		}

		return $s;
	}
}