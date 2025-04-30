<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Menu;

class MenuTest extends TestCase
{
    protected $menu;

    protected function setUp(): void
    {
        $mysqli = new \mysqli("localhost", "root", "", "fastfood_db", 3307);
        $this->menu = new Menu($mysqli);
    }

    public function testGetAllItems()
    {
        $allItems = $this->menu->getAllItems();
        $this->assertIsArray($allItems);
        $this->assertNotEmpty($allItems, "Menu items should not be empty.");
    }

    public function testGetItemById()
    {
        $item = $this->menu->getItemById(1);
        $this->assertIsArray($item);
        $this->assertEquals("Los Pollos Locos Wings", $item['item_name']);
    }

    public function testGetInvalidItemById()
    {
        $item = $this->menu->getItemById(9999);
        $this->assertNull($item);
    }
}
