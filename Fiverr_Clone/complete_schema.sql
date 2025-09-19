-- Complete SQL Schema for Fiverr Clone
-- Run this script to create all necessary tables and sample data

-- Create database (uncomment if needed)
-- CREATE DATABASE IF NOT EXISTS fiverr_database;
-- USE fiverr_database;

-- Drop existing tables if they exist (in correct order due to foreign keys)
DROP TABLE IF EXISTS offers;
DROP TABLE IF EXISTS proposals;
DROP TABLE IF EXISTS subcategories;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS fiverr_clone_users;

-- Create users table
CREATE TABLE fiverr_clone_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    is_client BOOLEAN NOT NULL DEFAULT FALSE,
    is_administrator BOOLEAN NOT NULL DEFAULT FALSE,
    bio_description TEXT,
    display_picture TEXT,
    contact_number VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL,
    category_description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create subcategories table
CREATE TABLE subcategories (
    subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    subcategory_name VARCHAR(255) NOT NULL,
    subcategory_description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

-- Create proposals table
CREATE TABLE proposals (
    proposal_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    description TEXT NOT NULL,
    image TEXT,
    min_price INT NOT NULL,
    max_price INT NOT NULL,
    view_count INT DEFAULT 0,
    category_id INT,
    subcategory_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL,
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id) ON DELETE SET NULL
);

-- Create offers table with unique constraint
CREATE TABLE offers (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    description TEXT NOT NULL,
    proposal_id INT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (proposal_id) REFERENCES proposals(proposal_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_proposal (user_id, proposal_id)
);

-- Insert default categories
INSERT INTO categories (category_name, category_description) VALUES 
('Technology', 'Technology related services and solutions'),
('Design & Creative', 'Design and creative services'),
('Digital Marketing', 'Digital marketing and advertising services'),
('Writing & Translation', 'Writing and translation services'),
('Video & Animation', 'Video and animation services'),
('Music & Audio', 'Music and audio services'),
('Programming & Tech', 'Programming and technical services'),
('Business', 'Business and consulting services');

-- Insert subcategories for Technology
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(1, 'Web Development', 'Front-end, back-end, and full-stack web development'),
(1, 'Mobile App Development', 'iOS and Android mobile application development'),
(1, 'Game Development', 'Game design and development services'),
(1, 'DevOps', 'DevOps and infrastructure services'),
(1, 'Data Science', 'Data analysis and machine learning services'),
(1, 'Cybersecurity', 'Security and protection services');

-- Insert subcategories for Design & Creative
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(2, 'Logo Design', 'Logo and brand identity design'),
(2, 'Web Design', 'Website and UI/UX design'),
(2, 'Graphic Design', 'Print and digital graphic design'),
(2, 'Illustration', 'Custom illustrations and artwork'),
(2, '3D Design', '3D modeling and rendering services');

-- Insert subcategories for Digital Marketing
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(3, 'Social Media Marketing', 'Social media management and advertising'),
(3, 'SEO', 'Search engine optimization services'),
(3, 'Content Marketing', 'Content creation and marketing strategy'),
(3, 'Email Marketing', 'Email campaign management'),
(3, 'PPC Advertising', 'Pay-per-click advertising management');

-- Insert subcategories for Writing & Translation
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(4, 'Content Writing', 'Blog posts, articles, and web content'),
(4, 'Copywriting', 'Sales and marketing copy'),
(4, 'Translation', 'Language translation services'),
(4, 'Proofreading', 'Editing and proofreading services'),
(4, 'Technical Writing', 'Technical documentation and manuals');

-- Insert subcategories for Video & Animation
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(5, 'Video Editing', 'Video post-production and editing'),
(5, 'Animation', '2D and 3D animation services'),
(5, 'Motion Graphics', 'Motion graphics and visual effects'),
(5, 'Video Production', 'Full video production services'),
(5, 'Whiteboard Animation', 'Whiteboard and explainer videos');

-- Insert subcategories for Music & Audio
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(6, 'Music Production', 'Music composition and production'),
(6, 'Voice Over', 'Voice acting and narration'),
(6, 'Audio Editing', 'Audio post-production and editing'),
(6, 'Sound Design', 'Sound effects and audio design'),
(6, 'Mixing & Mastering', 'Audio mixing and mastering services');

-- Insert subcategories for Programming & Tech
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(7, 'Software Development', 'Custom software and application development'),
(7, 'Database Design', 'Database design and optimization'),
(7, 'API Development', 'REST and GraphQL API development'),
(7, 'Blockchain', 'Blockchain and cryptocurrency development'),
(7, 'AI & Machine Learning', 'Artificial intelligence and ML solutions');

-- Insert subcategories for Business
INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES 
(8, 'Business Consulting', 'Strategic business consulting'),
(8, 'Financial Planning', 'Financial analysis and planning'),
(8, 'Market Research', 'Market analysis and research'),
(8, 'Project Management', 'Project planning and management'),
(8, 'Legal Services', 'Legal consultation and documentation');

-- Insert sample users (optional - for testing)
-- Password for all sample users is 'password123' (hashed)
INSERT INTO fiverr_clone_users (username, email, password, is_client, is_administrator, contact_number, bio_description) VALUES 
('admin', 'admin@fiverrclone.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, '1234567890', 'System Administrator'),
('john_client', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 0, '0987654321', 'Looking for talented freelancers'),
('jane_freelancer', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 0, '1122334455', 'Professional web developer with 5+ years experience');

-- Insert sample proposals (optional - for testing)
INSERT INTO proposals (user_id, description, image, min_price, max_price, category_id, subcategory_id) VALUES 
(3, 'Professional website development using modern technologies like React and Node.js. I will create a responsive, fast, and SEO-optimized website for your business.', 'sample1.jpg', 5000, 15000, 1, 1),
(3, 'Mobile app development for iOS and Android platforms. Native and cross-platform solutions available.', 'sample2.jpg', 10000, 25000, 1, 2),
(3, 'Logo design and brand identity package. Includes logo variations, color palette, and brand guidelines.', 'sample3.jpg', 2000, 5000, 2, 1);

-- Create indexes for better performance
CREATE INDEX idx_proposals_category ON proposals(category_id);
CREATE INDEX idx_proposals_subcategory ON proposals(subcategory_id);
CREATE INDEX idx_proposals_user ON proposals(user_id);
CREATE INDEX idx_offers_proposal ON offers(proposal_id);
CREATE INDEX idx_offers_user ON offers(user_id);
CREATE INDEX idx_subcategories_category ON subcategories(category_id);

-- Show completion message
SELECT 'Database schema created successfully!' as message;
SELECT COUNT(*) as categories_count FROM categories;
SELECT COUNT(*) as subcategories_count FROM subcategories;
SELECT COUNT(*) as users_count FROM fiverr_clone_users;
