<?php

class SqlHelper
{
	/**
	 *
	 */
	public static function removeComment($sql)
	{
		$sqlUncomment = '';
		$len = strlen($sql);

		$i = 0;
		while ($i < $len)
		{
			$ch = $sql[$i];

			if ($ch === '\'')
			{
				$ss = self::skipString($sql, $len, $i, '\'');
				$sqlUncomment .= $ss;
				continue;
			}
			if ($ch === '/')
			{
				if ($i + 1 < $len && $sql[$i + 1] === '*')
				{
					$posCommentEnd = strpos($sql, '*/', $i + 2);
					if ($posCommentEnd !== false)
					{
						$i = $posCommentEnd + 2;
						continue;
					}
				}
			}
			if ($ch === '-')
			{
				if ($i + 1 < $len && $sql[$i + 1] === '-')
				{
					$posCommentEnd = strpos($sql, "\n", $i + 2);
					if ($posCommentEnd !== false)
					{
						$i = $posCommentEnd;
						continue;
					}
					break; // skip all comment to end of file
				}
			}

			++$i;

			$sqlUncomment .= $ch;
		}

		return $sqlUncomment;
	}

	/**
	 *
	 */
	public function removeExtraChars($sql)
	{
		
		return $sql;
	}

	/**
	 *
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