<?php

$lang['db_invalid_connection_str'] = 'No se puede determinar la configuracion de la base de datos usando la informacion suministrada.';
$lang['db_unable_to_connect'] = 'No se puede conectar al servidor de base de datos usando la configuracion suministrada.';
$lang['db_unable_to_select'] = 'No se puede seleccionar la base de datos especificada: %s';
$lang['db_unable_to_create'] = 'No se puede crear la base de datos especificada: %s';
$lang['db_invalid_query'] = 'El query no es valido.';
$lang['db_must_set_table'] = 'Debe seleccionar la tabla de base de datos que se utilizará con su consulta.';
$lang['db_must_use_set'] = 'Debe utilizar el metodo "set" para actualizar.';
$lang['db_must_use_index'] = 'Debe especificar un índice para que coincida con el de actualizaciones por lotes.';
$lang['db_batch_missing_index'] = 'Una o mas filas enviadas para la actualizacion por lotes no tiene el indice especificado.';
$lang['db_must_use_where'] = 'Las actualizaciones no estan permitidas a menos que contengan la sentencia "where".';
$lang['db_del_must_use_where'] = 'No se permite la eliminacion a menos que contengan la sentencia "where" o "like".';
$lang['db_field_param_missing'] = 'Para recuperar los campos se requiere el nombre de la tabla como un parámetro.';
$lang['db_unsupported_function'] = 'Esta opcion no esta disponible para la base de datos que esta usando.';
$lang['db_transaction_failure'] = 'Fallo en la transaccion: Se ejecuto un Rollback.';
$lang['db_unable_to_drop'] = 'No se puede eliminar la base de datos especificada.';
$lang['db_unsuported_feature'] = 'Opcion no soportada para la base de datos que esta utilizando.';
$lang['db_unsuported_compression'] = 'El servidor no soporta el formato de compresion de archivo que usted selecciono.';
$lang['db_filepath_error'] = 'No se pueden escribir datos en la ruta que usted indico.';
$lang['db_invalid_cache_path'] = 'La ruta del cache no es valida o no tiene permisos de escritura.';
$lang['db_table_name_required'] = 'Se requiere el nombre de una tabla para ejecutar la accion.';
$lang['db_column_name_required'] = 'Se requiere el nombre de una columna para ejecutar la accion.';
$lang['db_column_definition_required'] = 'Se requiere la definicion de una columna para ejecutar la accion.';
$lang['db_unable_to_set_charset'] = 'No se puede establecer el juego de caracteres de conexión del cliente: %s';
$lang['db_error_heading'] = 'Ocurrio un error en la base de datos';

/* End of file db_lang.php */
/* Location: ./system/language/english/db_lang.php */