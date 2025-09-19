<?php  
require_once 'Database.php';

/**
 * Class for handling Subcategory-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Subcategory extends Database {

    /**
     * Creates a new Subcategory.
     * @param int $category_id The parent category ID.
     * @param string $subcategory_name The subcategory name.
     * @param string $subcategory_description The subcategory description.
     * @return bool True on success, false on failure.
     */
    public function createSubcategory($category_id, $subcategory_name, $subcategory_description) {
        $sql = "INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES (?, ?, ?)";
        return $this->executeNonQuery($sql, [$category_id, $subcategory_name, $subcategory_description]);
    }

    /**
     * Retrieves all active subcategories.
     * @return array
     */
    public function getSubcategories() {
        $sql = "SELECT s.*, c.category_name 
                FROM subcategories s 
                JOIN categories c ON s.category_id = c.category_id 
                WHERE s.is_active = TRUE AND c.is_active = TRUE 
                ORDER BY c.category_name ASC, s.subcategory_name ASC";
        return $this->executeQuery($sql);
    }

    /**
     * Retrieves subcategories by category ID.
     * @param int $category_id The category ID.
     * @return array
     */
    public function getSubcategoriesByCategoryId($category_id) {
        $sql = "SELECT * FROM subcategories WHERE category_id = ? AND is_active = TRUE ORDER BY subcategory_name ASC";
        return $this->executeQuery($sql, [$category_id]);
    }

    /**
     * Retrieves a single subcategory by ID.
     * @param int $subcategory_id The subcategory ID.
     * @return array|null
     */
    public function getSubcategoryById($subcategory_id) {
        $sql = "SELECT s.*, c.category_name 
                FROM subcategories s 
                JOIN categories c ON s.category_id = c.category_id 
                WHERE s.subcategory_id = ? AND s.is_active = TRUE AND c.is_active = TRUE";
        return $this->executeQuerySingle($sql, [$subcategory_id]);
    }

    /**
     * Updates a subcategory.
     * @param int $subcategory_id The subcategory ID.
     * @param int $category_id The parent category ID.
     * @param string $subcategory_name The new subcategory name.
     * @param string $subcategory_description The new subcategory description.
     * @return bool True on success, false on failure.
     */
    public function updateSubcategory($subcategory_id, $category_id, $subcategory_name, $subcategory_description) {
        $sql = "UPDATE subcategories SET category_id = ?, subcategory_name = ?, subcategory_description = ? WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$category_id, $subcategory_name, $subcategory_description, $subcategory_id]);
    }

    /**
     * Soft deletes a subcategory (sets is_active to FALSE).
     * @param int $subcategory_id The subcategory ID.
     * @return bool True on success, false on failure.
     */
    public function deleteSubcategory($subcategory_id) {
        $sql = "UPDATE subcategories SET is_active = FALSE WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$subcategory_id]);
    }
}
?>
