<?php
namespace Model;

use Model\MapperAbstract;

class RecordMapper extends MapperAbstract {

    protected $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db){
        $this->db = $db;
    }

    // Find out how many items are in the table
    /**
     * @return string
     */
    public function getCount(){
        $total = $this->db->query('
                SELECT
                    COUNT(*)
                FROM
                    guestbook
            ')->fetchColumn();
        return $total;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @param null $order
     * @return array
     */
    public function find($limit = null, $offset = null, $order = null){
        $statement = $this->db->prepare("
                SELECT
                    *
                FROM
                    guestbook
                ORDER BY
                    add_date $order
                LIMIT
                    :limit
                OFFSET
                    :offset
            ");

        // Bind the query params
        $statement->bindParam(':limit', $limit, \PDO:: PARAM_INT);
        $statement->bindParam(':offset', $offset, \PDO:: PARAM_INT);
        $statement->execute();

        $records = array();
        if ($statement->rowCount() > 0) {
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $iterator = new \IteratorIterator($statement);

            foreach ($iterator as $row) {
                $record = new Record();
                $records[] = $this->populate($record, $row);;
            }
        }

        return $records;
    }

    /**
     * @param Record $record
     */
    public function save(Record &$record){
        if ($record->id) {
            $sql = "UPDATE guestbook SET name = :name, email = :email, description = :description, when = :when, ip = :ip WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("bar", $record->bar);
            $statement->bindParam("id", $record->id);
            $statement->execute();
        } else {
            try {
                $sql = '';
                $optional = array();
                if ($record->file){
                    $optional[] = 'file';
                }
                if ($record->homepage){
                    $optional[] = 'homepage';
                }
                if (count($optional)){
                    $sql = "INSERT INTO guestbook (name, email, description, add_date, ip, " . implode(', ', $optional) . ") VALUES (:name, :email, :description, :add_date, :ip, :" . implode(', :', $optional) . ")";
                } else {
                    $sql = "INSERT INTO guestbook (name, email, description, add_date, ip) VALUES (:name, :email, :description, :add_date, :ip)";
                }
                $statement = $this->db->prepare($sql);
                $statement->bindParam("name", $record->name);
                $statement->bindParam("email", $record->email);
                $statement->bindParam("description", $record->description);
                $statement->bindParam("add_date", $record->when);
                $statement->bindParam("ip", $record->ip);
                if ($record->file){
                    $statement->bindParam("file", $record->file);
                }
                if ($record->homepage){
                    $statement->bindParam("homepage", $record->homepage);
                }
                $statement->execute();
            } catch (Exception $e) {
                die("Oh noes! There's an error in the query!");
            }
            $record->id = $this->db->lastInsertId();
        }
    }

    /**
     * @param $record
     * @param array $data
     * @return mixed
     */
    public function populate($record, array $data){
        $record->id = $data['id'];
        $record->name = $data['name'];
        $record->email = $data['email'];
        $record->description = $data['description'];
        $record->when = $data['add_date'];
        $record->ip = $data['ip'];
        $record->file = $data['file'];

        return $record;
    }

}