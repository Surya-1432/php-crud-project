-- Create tables
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS students (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(15) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert into users
INSERT INTO users (username, password, created_at) VALUES
('john_doe', 'password123', NOW()),
('jane_smith', 'securepass', NOW()),
('alex_kumar', 'mysecret', NOW());

-- Insert into posts (linking to user IDs 1, 2, and 3)
INSERT INTO posts (user_id, title, content, created_at) VALUES
(1, 'First Post', 'This is the first sample post.', NOW()),
(2, 'PHP Basics', 'Learning PHP for web development.', NOW()),
(3, 'Database Design', 'Introduction to relational databases.', NOW());

-- Insert into students
INSERT INTO students (name, email, phone, created_at) VALUES
('Ravi Kumar', 'ravi@example.com', '9876543210', NOW()),
('Priya Sharma', 'priya@example.com', '9876543211', NOW()),
('Arjun Patel', 'arjun@example.com', '9876543212', NOW());
