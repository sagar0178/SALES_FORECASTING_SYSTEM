/* Create Admin Table */

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adminid VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

/* Add Admin User in Admin Table */

INSERT INTO admin (adminid, password) VALUES ('admin', 'adminpass');
