<?php  
require_once 'Database.php';

/**
 * Class for handling Category-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Category extends Database {

    /**
     * Creates a new Category.
     * @param string $category_name The category name.
     * @param string $category_description The category description.
     * @return bool True on success, false on failure.
     */
    public function createCategory($category_name, $category_description) {
        $sql = "INSERT INTO categories (category_name, category_description) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$category_name, $category_description]);
    }

    /**
     * Retrieves all active categories.
     * @return array
     */
    public function getCategories() {
        $sql = "SELECT * FROM categories WHERE is_active = TRUE ORDER BY category_name ASC";
        return $this->executeQuery($sql);
    }

    /**
     * Retrieves a single category by ID.
     * @param int $category_id The category ID.
     * @return array|null
     */
    public function getCategoryById($category_id) {
        $sql = "SELECT * FROM categories WHERE category_id = ? AND is_active = TRUE";
        return $this->executeQuerySingle($sql, [$category_id]);
    }

    /**
     * Updates a category.
     * @param int $category_id The category ID.
     * @param string $category_name The new category name.
     * @param string $category_description The new category description.
     * @return bool True on success, false on failure.
     */
    public function updateCategory($category_id, $category_name, $category_description) {
        $sql = "UPDATE categories SET category_name = ?, category_description = ? WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$category_name, $category_description, $category_id]);
    }

    /**
     * Soft deletes a category (sets is_active to FALSE).
     * @param int $category_id The category ID.
     * @return bool True on success, false on failure.
     */
    public function deleteCategory($category_id) {
        $sql = "UPDATE categories SET is_active = FALSE WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$category_id]);
    }

    /**
     * Gets categories with their subcategories.
     * @return array
     */
    public function getCategoriesWithSubcategories() {
        $sql = "SELECT 
                    c.category_id, 
                    c.category_name, 
                    c.category_description,
                    s.subcategory_id, 
                    s.subcategory_name, 
                    s.subcategory_description
                FROM categories c 
                LEFT JOIN subcategories s ON c.category_id = s.category_id AND s.is_active = TRUE
                WHERE c.is_active = TRUE 
                ORDER BY c.category_name ASC, s.subcategory_name ASC";
        return $this->executeQuery($sql);
    }
}
?>
