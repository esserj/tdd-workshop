<?php

namespace App\Test;

use App\Books\BookStoreInterface;
use App\Entity\Book;
use App\Service\BookService;

class BookStoreTest extends DatabaseTest
{
    /**
     * @var BookStoreInterface
     */
    private $bookStore;

    public function setUp()
    {
        parent::setUp();

        $this->bookStore = new BookService($this->getConnection()->getConnection());

    }

    public function testBooksCanBeAddedToTheStore()
    {
        $book = new Book(123, 'My added Book', 'summary', 'a123');
        static::assertTrue($this->bookStore->addBook($book));
        static::assertEquals(1, $this->getConnection()->getRowCount('book', 'id = 123'));
    }

    public function tearDown()
    {
        unset($this->bookStore);
    }
}
