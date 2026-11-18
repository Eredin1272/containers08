<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../site/modules/page.php';

final class PageTest extends TestCase
{
    public function testRenderPage(): void
    {
        $page = new Page(__DIR__ . '/../../site/templates/index.tpl');

        $html = $page->Render([
            'title' => 'Test',
            'content' => 'Hello',
        ]);

        self::assertStringContainsString('<h1>Test</h1>', $html);
        self::assertStringContainsString('<p>Hello</p>', $html);
    }
}