<?php
/**
 * Configuración de entorno para Hostinger
 *
 * INSTRUCCIONES:
 * 1. Copia los datos de tu panel Hostinger → Databases → MySQL Databases
 * 2. Actualiza los valores de abajo con tus credenciales reales
 * 3. Este archivo es cargado automáticamente por application/config/database.php
 *
 * SEGURIDAD: Este archivo está bloqueado por .htaccess para acceso directo
 */

// Credenciales de base de datos Hostinger
putenv('DB_HOST=localhost');
putenv('DB_USER=TU_USUARIO_HOSTINGER');   // Ej: u123456789_pos
putenv('DB_PASS=TU_PASSWORD_SEGURA');      // La contraseña de tu BD
putenv('DB_NAME=TU_NOMBRE_DE_BD');         // Ej: u123456789_multipos
