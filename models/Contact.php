<?php 
class Contact {
    private $conn,
            $table_name = 'contacts';

    public  $id,
            $name,
            $email,
            $subject,
            $message,
            $status,
            $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table_name . ' SET name=:name, email=:email, subject=:subject, message=:message';
        
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->subject = htmlspecialchars(strip_tags($this->subject));
        $this->message = htmlspecialchars(strip_tags($this->message));
        
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':message', $this->message);

        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table_name . ' ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne() {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = 'UPDATE ' . $this->table_name . ' SET name=:name, email=:email, subject=:subject, message=:message, status=:status WHERE id=:id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name' , $this->name);
        $stmt->bindParam(':email' , $this->email);
        $stmt->bindParam(':subject' , $this->subject);
        $stmt->bindParam(':message' , $this->message);
        $stmt->bindParam(':status' , $this->status);
        $stmt->bindParam(':id' , $this->id);

        return $stmt->execute();
    } 


    public function delete() {
        $query = 'DELETE FROM ' . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id); // 1st ? gets $this->id
        // $stmt->bindParam(":id", $this->id);  // More clear!
        return $stmt->execute();
    }
}