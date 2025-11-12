-- Add GitHub and LinkedIn columns to users table
ALTER TABLE users 
ADD COLUMN github_url VARCHAR(255) NULL AFTER bio,
ADD COLUMN linkedin_url VARCHAR(255) NULL AFTER github_url;
