"CREATE DATABASE IF NOT EXISTS mama_fua_services;
USE mama_fua_services;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  username VARCHAR(80) NOT NULL UNIQUE,
  email VARCHAR(180) NOT NULL UNIQUE,
  phone VARCHAR(30) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  profile_image VARCHAR(255) DEFAULT NULL,
  address TEXT DEFAULT NULL,
  status ENUM('active','suspended') NOT NULL DEFAULT 'active',
  remember_token VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_users_email (email),
  INDEX idx_users_role (role)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  description TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT DEFAULT NULL,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(160) NOT NULL UNIQUE,
  description TEXT NOT NULL,
  short_description VARCHAR(255) DEFAULT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  duration VARCHAR(80) DEFAULT '1 hour',
  image VARCHAR(255) DEFAULT NULL,
  featured TINYINT(1) NOT NULL DEFAULT 0,
  availability ENUM('available','booked','unavailable') NOT NULL DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  INDEX idx_services_featured (featured),
  INDEX idx_services_availability (availability)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cleaners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  full_name VARCHAR(120) NOT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  email VARCHAR(180) DEFAULT NULL,
  experience VARCHAR(80) DEFAULT NULL,
  rating DECIMAL(3,2) DEFAULT 0.00,
  skills TEXT DEFAULT NULL,
  availability ENUM('available','busy','on_leave','offline') NOT NULL DEFAULT 'available',
  photo VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  service_id INT NOT NULL,
  cleaner_id INT DEFAULT NULL,
  booking_date DATE NOT NULL,
  booking_time VARCHAR(20) NOT NULL,
  address TEXT NOT NULL,
  notes TEXT DEFAULT NULL,
  status ENUM('pending','confirmed','cleaner_assigned','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
  payment_method ENUM('mpesa','paypal','bank_transfer','cash_on_delivery') NOT NULL DEFAULT 'cash_on_delivery',
  payment_status ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending',
  total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT,
  FOREIGN KEY (cleaner_id) REFERENCES cleaners(id) ON DELETE SET NULL,
  INDEX idx_bookings_status (status),
  INDEX idx_bookings_date (booking_date)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT NOT NULL,
  payment_method VARCHAR(80) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending',
  transaction_reference VARCHAR(120) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  service_id INT NOT NULL,
  rating INT NOT NULL,
  review_text TEXT NOT NULL,
  images VARCHAR(255) DEFAULT NULL,
  approved TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(180) NOT NULL,
  phone VARCHAR(30) DEFAULT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS newsletter (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(180) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blogs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(220) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  content TEXT NOT NULL,
  author VARCHAR(120) DEFAULT NULL,
  category VARCHAR(120) DEFAULT NULL,
  image VARCHAR(255) DEFAULT NULL,
  published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  site_name VARCHAR(150) DEFAULT 'Mama Fua Services',
  logo VARCHAR(255) DEFAULT NULL,
  favicon VARCHAR(255) DEFAULT NULL,
  email VARCHAR(180) DEFAULT 'befrineclaire@gmail.com',
  phone VARCHAR(30) DEFAULT '0743468419',
  address TEXT DEFAULT 'Umoja, Nairobi',
  social_links TEXT DEFAULT NULL,
  seo_title VARCHAR(220) DEFAULT NULL,
  seo_description TEXT DEFAULT NULL,
  maintenance_mode TINYINT(1) NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS password_resets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(180) NOT NULL,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  action VARCHAR(255) NOT NULL,
  details TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO users (full_name, username, email, phone, password_hash, role, status) VALUES
('Administrator', 'admin', 'admin@mama-fua.com', '0700000000', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active');

INSERT INTO admins (user_id) VALUES (1);

INSERT INTO categories (name, slug, description) VALUES
('Home Cleaning', 'home-cleaning', 'Reliable home cleaning services'),
('Laundry', 'laundry', 'Laundry pickup and delivery');

INSERT INTO services (category_id, name, slug, description, short_description, price, duration, image, featured, availability) VALUES
(1, 'House Cleaning', 'house-cleaning', 'Complete home cleaning with attention to detail.', 'Sparkling homes with professional care.', 2500.00, '2 hours', 'house-cleaning.jpg', 1, 'available'),
(1, 'Bathroom Cleaning', 'bathroom-cleaning', 'Deep sanitization for bathrooms.', 'Fresh and hygienic bathrooms.', 1800.00, '1.5 hours', 'bathroom-cleaning.jpg', 1, 'available'),
(2, 'Laundry Pickup & Delivery', 'laundry-pickup-delivery', 'Convenient laundry pickup and delivery service.', 'Fresh laundry at your convenience.', 1200.00, 'Same day', 'laundry.jpg', 1, 'available');

INSERT INTO cleaners (full_name, phone, email, experience, rating, skills, availability) VALUES
('Grace Wanjiku', '0712345678', 'grace@example.com', '5 years', 4.9, 'House Cleaning, Deep Cleaning', 'available'),
('John Mugo', '0723456789', 'john@example.com', '4 years', 4.8, 'Laundry, Office Cleaning', 'available');

INSERT INTO settings (site_name, email, phone, address, seo_title, seo_description) VALUES
('Mama Fua Services', 'befrineclaire@gmail.com', '0743468419', 'Umoja, Nairobi', 'Mama Fua Services | Professional Cleaning Services', 'Professional cleaning services in Umoja and beyond.');

INSERT INTO blogs (title, slug, content, author, category, image) VALUES
('How to Keep Your Home Fresh Weekly', 'keep-home-fresh-weekly', 'Simple habits to keep your home fresh every week.', 'Admin', 'Cleaning Tips', 'blog1.jpg'),
('Best Practices for Laundry Care', 'best-practices-laundry-care', 'Keep your clothes bright and fresh with these tips.', 'Admin', 'Laundry', 'blog2.jpg');
