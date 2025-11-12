-- Add User Recommendations System
-- Users can recommend other users (one time per user)

USE uiuarchive;

-- Add recommendations_count column to users table
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS recommendations_count INT DEFAULT 0 AFTER profile_image;

-- Create user_recommendations table to track who recommended whom (one time per user)
CREATE TABLE IF NOT EXISTS user_recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    recommender_user_id INT NOT NULL COMMENT 'User who gives the recommendation',
    recommended_user_id INT NOT NULL COMMENT 'User who receives the recommendation',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_recommendation (recommender_user_id, recommended_user_id),
    FOREIGN KEY (recommender_user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recommended_user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_recommender (recommender_user_id),
    INDEX idx_recommended (recommended_user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
