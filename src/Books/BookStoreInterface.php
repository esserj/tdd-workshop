<?php

namespace App\Books;

use App\Entity\Book;

interface BookStoreInterface
{
    public function addBook(Book $book): bool;
}
