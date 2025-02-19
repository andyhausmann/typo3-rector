<?php

declare(strict_types=1);

namespace Ssch\TYPO3Rector\TypoScript\Conditions;

use Ssch\TYPO3Rector\ArrayUtility;

final class LoginUserConditionMatcher implements TyposcriptConditionMatcher
{
    /**
     * @var string
     */
    private const TYPE = 'loginUser';

    public function change(string $condition): ?string
    {
        preg_match('#' . self::TYPE . '\s*=\s*(.*)#', $condition, $matches);

        if (! is_array($matches)) {
            return $condition;
        }

        if (! isset($matches[1]) || '' === $matches[1]) {
            return 'loginUser("*") == false';
        }

        $values = ArrayUtility::trimExplode(',', $matches[1], true);

        return sprintf('loginUser("%s")', implode(',', $values));
    }

    public function shouldApply(string $condition): bool
    {
        return 1 === preg_match('#^' . self::TYPE . self::ZERO_ONE_OR_MORE_WHITESPACES . '=#', $condition);
    }
}
