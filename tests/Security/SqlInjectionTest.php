<?php

use PHPUnit\Framework\TestCase;

class SqlInjectionTest extends TestCase
{
    /** Source must not contain raw $_GET interpolation in SQL */
    public function testAjaxSearchHasNoRawInterpolation(): void
    {
        $source = file_get_contents(ROOT_PATH . 'ajax-db-search.php');
        $this->assertStringNotContainsString(
            "LIKE '{\$_GET",
            $source,
            'ajax-db-search.php interpolates $_GET directly into SQL'
        );
        $this->assertStringNotContainsString(
            "LIKE '\$_GET",
            $source,
            'ajax-db-search.php interpolates $_GET directly into SQL'
        );
    }

    /** Must use a prepared statement */
    public function testAjaxSearchUsesPreparedStatement(): void
    {
        $source = file_get_contents(ROOT_PATH . 'ajax-db-search.php');
        $this->assertStringContainsString(
            'prepare(',
            $source,
            'No prepared statement found in ajax-db-search.php'
        );
        $this->assertStringContainsString(
            'bind_param',
            $source,
            'No bind_param found in ajax-db-search.php'
        );
    }

    /** CORS wildcard must not be set in ajax-db-search.php */
    public function testAjaxSearchHasNoCorsWildcard(): void
    {
        $source = file_get_contents(ROOT_PATH . 'ajax-db-search.php');
        $this->assertStringNotContainsString(
            'Allow-Origin: *',
            $source,
            'ajax-db-search.php still sets wildcard CORS header'
        );
    }
}
