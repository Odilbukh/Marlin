<?php
namespace App\Model;

use Aura\SqlQuery\QueryFactory;
use PDO;

class Users
{
    public function __construct(QueryFactory $queryFactory, PDO $pdo)
    {
        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])->from('users');

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}