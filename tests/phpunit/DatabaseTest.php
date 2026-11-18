<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../site/modules/database.php';

final class DatabaseTest extends TestCase
{
    private Database $database;

    protected function setUp(): void
    {
        $this->database = new Database(':memory:');

        $schema = file_get_contents(__DIR__ . '/../../sql/schema.sql');
        $this->database->Execute($schema);
    }

    public function testDatabaseConnection(): void
    {
        $rows = $this->database->Fetch('SELECT 1 AS value');

        self::assertSame(1, (int) $rows[0]['value']);
    }

    public function testInitialPageCount(): void
    {
        self::assertSame(3, (int) $this->database->Count('page'));
    }

    public function testCreatePage(): void
    {
        $id = $this->database->Create('page', [
            'title' => 'Test',
            'content' => 'Test content',
        ]);

        self::assertGreaterThan(0, (int) $id);

        $page = $this->database->Read('page', $id);

        self::assertNotNull($page);
        self::assertSame('Test', $page['title']);
        self::assertSame('Test content', $page['content']);
    }

    public function testReadPage(): void
    {
        $page = $this->database->Read('page', 1);

        self::assertNotNull($page);
        self::assertSame('Page 1', $page['title']);
        self::assertSame('Content 1', $page['content']);
    }
}