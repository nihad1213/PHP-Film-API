<?php

class FilmGateway {
    private PDO $conn;
    
    public function __construct(Database $database) {
        $this->conn = $database->getConnect();
    }

    /**
     * Get all Films from the database
     * @return array
     */
    public function getAll(): array {
        $sql = "SELECT * FROM `films`";

        $stmt = $this->conn->query($sql);
        
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Get specific Film by its ID
     * @param string $id
     * @return array|false
     */
    public function get(string $id): array|false {
        $sql = "SELECT * FROM `films` WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new Film to the database
     * @param array $data
     * @return string
     */
    public function create(array $data): string {
        $sql = "INSERT INTO `films` 
                (`title`, `genre`, `director`, `release_date`, `duration`, `rating`, `description`, `language`, `country`, `budget`, `box_office`, `created_at`, `updated_at`) 
                VALUES 
                (:title, :genre, :director, :release_date, :duration, :rating, :description, :language, :country, :budget, :box_office, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(':genre', $data['genre'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':director', $data['director'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':release_date', $data['release_date'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':duration', $data['duration'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':rating', $data['rating'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':language', $data['language'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':country', $data['country'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':budget', $data['budget'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':box_office', $data['box_office'] ?? null, PDO::PARAM_STR);
    
        $stmt->execute();
    
        return $this->conn->lastInsertId();
    }

    /**
     * Update a specific Film in the database
     * @param string $id
     * @param array $data
     * @return void
     */
    public function update(string $id, array $data): void {
        try {
            $sql = "UPDATE `films` SET 
                    `title` = :title, 
                    `genre` = :genre, 
                    `director` = :director, 
                    `release_date` = :release_date, 
                    `duration` = :duration, 
                    `rating` = :rating, 
                    `description` = :description, 
                    `language` = :language, 
                    `country` = :country, 
                    `budget` = :budget, 
                    `box_office` = :box_office, 
                    `updated_at` = CURRENT_TIMESTAMP 
                    WHERE id = :id";
    
            $stmt = $this->conn->prepare($sql);
    
            $stmt->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindValue(':genre', $data['genre'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':director', $data['director'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':release_date', $data['release_date'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':duration', $data['duration'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':rating', $data['rating'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':description', $data['description'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':language', $data['language'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':country', $data['country'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':budget', $data['budget'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':box_office', $data['box_office'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
    
            if ($stmt->rowCount() === 0) {
                throw new Exception("Film with ID $id not found or no changes made.");
            }
    
            http_response_code(200);
            echo json_encode(["success" => "Film updated!", "id" => $id]);
    
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    /**
     * Delete a specific Film from the database
     * @param string $id
     * @return void
     */
    public function delete(string $id): void {
        $sql = "DELETE FROM `films` WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Film with ID $id not found.");
        }
    }
}
