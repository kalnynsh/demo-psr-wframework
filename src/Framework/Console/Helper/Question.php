<?php

namespace Framework\Console\Helper;

use Framework\Console\Input;
use Framework\Console\Output;

/**
 * Console input question helper
 */
class Question
{
    public static function choose(
        Input $input,
        Output $output,
        string $prompt,
        array $options
    ): string {
        $optionsWithComma = ' [' . \implode(',', $options) . ']: ';

        do {
            $output->write($prompt . $optionsWithComma);
            $choose = trim($input->read());
        } while (! \in_array($choose, $options, true));

        return $choose;
    }
}
