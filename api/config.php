<?php
// holds all global configuration variables
return
[
  /* Database definitions */
  "DB_NAME" => "jobsportaldb",
  "DB_HOST" => "localhost",
  "DB_PORT" => 3306,
  "DB_USERNAME" => "root",
  "DB_PASSWORT" => "R^O5%(?O{^faVS2F",
  "DB_CHARSET" => "utf8mb4",
  "DB_OPTIONS" => [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ]
];