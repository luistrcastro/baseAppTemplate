<?php

namespace App\Utilities;

use Illuminate\Support\Str;

class StringHelper
{
    /**
     * Changes snake_case into Title Case
     * @param string $str
     * @return string
     */
    private function snakeToTitleCase(string $str): string
    {
        return Str::of($str)->replace('_', ' ')->title()->toString();
    }

    /**
     * Changes snake_case into PascalCase
     * @param string $str
     * @return string
     */
    private function snakeToPascal(string $str): string
    {
        return str_replace('_', '', ucwords($str, '_'));
    }

    /**
     * Changes string with spaces into snake_case
     * @param string $str
     * @return string
     */
    private function stringToSnakeCase(string $str):string
    {
        return Str::of($str)->lower()->replace(' ', '_')->toString();
    }

    /**
     * Creates a slug using snake_case, will replace ' ' and '-' with _
     * @param string $str
     * @return string
     */
    private function createSlug(string $str):string
    {
        return Str::of($str)->lower()->replace(' ', '_')->replace('-', '_')->toString();
    }
}
