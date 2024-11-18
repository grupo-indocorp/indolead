> Volver al [README](./README.md)

# Documents

### Implementación del módulo de evaporación

**Actualizamos los datos de usuarios**

Seguimos de forma ordenada la migración e implmentación de datos

```bash
    php artisan migrate --path=/database/migrations/2024_11_08_181931_add_column_to_users_table.php
    php artisan migrate --path=/database/migrations/2024_11_11_131959_create_tipodocumentos_table.php
    php artisan db:seed --class=TipodocumentoSeeder
    php artisan migrate --path=/database/migrations/2024_11_11_133126_add_tipodocumento_to_users_table.php
    php artisan migrate --path=/database/migrations/2024_11_11_173815_create_estadousers_table.php
    php artisan migrate --path=/database/migrations/2024_11_11_173845_create_generousers_table.php
    php artisan migrate --path=/database/migrations/2024_11_11_173923_create_modalidadusers_table.php
    php artisan db:seed --class=EstadouserSeeder
    php artisan db:seed --class=GenerouserSeeder
    php artisan db:seed --class=ModalidaduserSeeder
    php artisan migrate --path=/database/migrations/2024_11_11_184810_add_foreing_keys_to_users_table.php
    php artisan migrate --path=/database/migrations/2024_11_12_113524_create_detallepagousers_table.php
    php artisan migrate --path=/database/migrations/2024_11_12_113552_create_detalleingresousers_table.php
    php artisan migrate --path=/database/migrations/2024_11_12_123943_create_contratotipos_table.php
    php artisan migrate --path=/database/migrations/2024_11_12_124049_create_planillaempresas_table.php
    php artisan db:seed --class=ContratotipoSeeder
    php artisan db:seed --class=PlanillaempresaSeeder
    php artisan migrate --path=/database/migrations/2024_11_12_130334_add_foreign_keys_to_detallepagousers_table.php
    php artisan migrate --path=/database/migrations/2024_11_14_130319_make_user_id_nullable_in_notificacions_table.php
    php artisan migrate --path=/database/migrations/2024_11_18_090548_add_comentario_gestion_to_notificacions_table.php
```

Ejecutando tinker
```bash
    php artisan tinker
    use App\Models\Notificaciontipo;
    $notificacion = new Notificaciontipo;
    $notificacion->nombre = "evaporación";
    $notificacion->save();
```
```bash
    use Spatie\Permission\Models\Permission;
    Permission::create(['name' => 'sistema.evaporacion-gestion']);
```