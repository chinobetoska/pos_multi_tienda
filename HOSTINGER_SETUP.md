# Guía de Despliegue en Hostinger

## Requisitos
- Hosting Hostinger con PHP 8.2+
- MySQL 5.7+ o MariaDB 10.3+
- Apache con mod_rewrite habilitado

---

## Paso 1 — Crear la Base de Datos en Hostinger

1. Entra al panel hPanel de Hostinger
2. Ve a **Databases → MySQL Databases**
3. Crea una nueva base de datos (ej: `u123456789_multipos`)
4. Crea un usuario de base de datos con contraseña segura
5. Asigna todos los privilegios al usuario sobre esa base de datos
6. Anota: **host** (generalmente `localhost`), **usuario**, **contraseña**, **nombre de BD**

---

## Paso 2 — Importar el Esquema SQL

1. Ve a **Databases → phpMyAdmin**
2. Selecciona tu base de datos
3. Clic en **Importar**
4. Selecciona el archivo: `install/assets/install.sql`
5. Clic en **Continuar**

---

## Paso 3 — Configurar Credenciales

1. Abre el archivo `env-config.php` en la raíz del proyecto
2. Actualiza con tus credenciales reales:

```php
putenv('DB_HOST=localhost');
putenv('DB_USER=u123456789_pos');    // Tu usuario de BD
putenv('DB_PASS=TuPasswordSegura');   // Tu contraseña
putenv('DB_NAME=u123456789_multipos'); // Tu nombre de BD
```

---

## Paso 4 — Configurar PHP 8.2

1. En hPanel ve a **Advanced → PHP Configuration**
2. Selecciona **PHP 8.2** (mínimo requerido)
3. Asegúrate de que estas extensiones estén habilitadas:
   - `mysqli`
   - `mbstring`
   - `json`
   - `openssl`
   - `session`

---

## Paso 5 — Subir Archivos

**Opción A — Via File Manager de Hostinger:**
1. Ve a **Files → File Manager**
2. Navega a `public_html/` (o el directorio de tu dominio)
3. Sube todos los archivos del proyecto

**Opción B — Via FTP:**
1. Usa credenciales FTP del panel Hostinger
2. Sube todos los archivos a `public_html/`

**Archivos a NO subir (opcional si quieres limpiar):**
- `install/` (después de importar el SQL ya no se necesita)
- `review_notes.md`
- `HOSTINGER_SETUP.md` (este archivo)

---

## Paso 6 — Verificar el Despliegue

1. Abre en el navegador: `https://tu-dominio.com/healthcheck.php`
2. Deberías ver una respuesta JSON con `"status": "ok"`
3. Si hay errores, el JSON te dirá exactamente qué está fallando

---

## Paso 7 — Acceder a la Aplicación

1. Ve a `https://tu-dominio.com/`
2. Deberías ver la pantalla de login
3. Credenciales por defecto (del SQL instalado): revisar el archivo `install/assets/install.sql` para ver usuarios creados

---

## Paso 8 — Limpieza Final (IMPORTANTE)

Después de confirmar que todo funciona:

1. **Eliminar directorio `/install/`** — ya está bloqueado por .htaccess pero conviene eliminarlo
2. **Eliminar `/healthcheck.php`** — contiene información del sistema
3. Cambiar la contraseña del admin desde el panel de Settings

---

## Troubleshooting

### Error 500 — Internal Server Error
- Verificar que PHP 8.2+ está seleccionado en hPanel
- Revisar logs en `application/logs/`

### Error de conexión a BD
- Verificar credenciales en `env-config.php`
- Confirmar que el usuario tiene permisos sobre la BD

### Página en blanco / 404
- Verificar que mod_rewrite está activo en Hostinger
- Confirmar que `.htaccess` se subió correctamente

### Login no funciona
- Verificar que la tabla `users` existe con datos en phpMyAdmin
- Los passwords en el SQL instalado pueden estar en MD5 — son compatibles con la nueva versión bcrypt

---

## Nota sobre Contraseñas

El sistema soporta migración automática de passwords MD5 (legacy) a bcrypt:
- Al hacer login, si el password está en MD5 antiguo, se valida y migra automáticamente a bcrypt
- Los usuarios existentes no necesitan cambiar su contraseña
