-- Insert test users
INSERT INTO users (username, email, password, role, created_at, updated_at) VALUES
('admin', 'admin@ekskul.com', '$2y$10$V5xJP5PJt3aXcvVx5P5pJe5P5P5P5P5P5P5P5P5P5P5P5P5P5P5P5', 'admin', NOW(), NOW()),
('guru1', 'guru1@ekskul.com', '$2y$10$V5xJP5PJt3aXcvVx5P5pJe5P5P5P5P5P5P5P5P5P5P5P5P5P5P5', 'guru', NOW(), NOW()),
('siswa1', 'siswa1@ekskul.com', '$2y$10$V5xJP5PJt3aXcvVx5P5pJe5P5P5P5P5P5P5P5P5P5P5P5P5P5P5', 'siswa', NOW(), NOW()),
('siswa2', 'siswa2@ekskul.com', '$2y$10$V5xJP5PJt3aXcvVx5P5pJe5P5P5P5P5P5P5P5P5P5P5P5P5P5P5', 'siswa', NOW(), NOW()),
('siswa3', 'siswa3@ekskul.com', '$2y$10$V5xJP5PJt3aXcvVx5P5pJe5P5P5P5P5P5P5P5P5P5P5P5P5P5P5', 'siswa', NOW(), NOW());
