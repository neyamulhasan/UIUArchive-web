-- Remove unused tables from database
-- Remove follows, events, and notifications tables

USE uiuarchive;

-- Drop tables
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS follows;
DROP TABLE IF EXISTS events;
