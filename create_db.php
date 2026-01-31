<?php

use Illuminate\Support\Facades\DB;

try {
    // Connect to default postgres database
    $pdo = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=postgres', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if database exists
    $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = 'airplane'");
    if ($stmt->rowCount() == 0) {
        // Create database
        $pdo->exec("CREATE DATABASE airplane");
        echo "Database 'airplane' created successfully!\n";
    } else {
        echo "Database 'airplane' already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nPlease create the database manually:";
    echo "\n1. Open pgAdmin or use Laragon's database manager";
    echo "\n2. Create a database named 'airplane'\n";
}
