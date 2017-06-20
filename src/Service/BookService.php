<?php

namespace App\Service;


use App\Books\BookStoreInterface;
use App\Entity\Book;

class BookService implements BookStoreInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * BookService constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function getBooks(): array
    {
        $result = $this->pdo->query(
            'SELECT * FROM `book_author` `ba` 
              INNER JOIN `author` `a` ON `ba`.`author_id` = `a`.`id`
              INNER JOIN `book` `b` ON `ba`.`book_id` = `b`.`id`'
        );
        $data = $result->fetchAll(\PDO::FETCH_ASSOC);
        if (false === $data) {
            return [];
        }
        return $data;
    }

    public function addBook(Book $book): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO book (id, title, summary, isbn) VALUES (:id, :title, :summary, :isbn)");
        $statement->bindValue(':id', $book->getId());
        $statement->bindValue(':title', $book->getTitle());
        $statement->bindValue(':summary', $book->getSummary());
        $statement->bindValue(':isbn', $book->getIsbn());
        return $statement->execute();
    }
}