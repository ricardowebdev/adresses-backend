<?php

// function ship_logs($level, $action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     $data = ['level' => $level,'action' => $action,'origin' => $origin,'description' => $description];
//     $u = [];
//     $u['codigo_usuario'] = (!is_null($codigo_usuario) ? $codigo_usuario : null);
//     $u['codigo_usuario_modificado'] = (!is_null($codigo_usuario_modificado) ? $codigo_usuario_modificado : null);

//     return app()->make(\App\Contracts\Repositories\LogRepositoryInterface::class)->create(array_merge($u, $data));
//     //return RegistraLogJob::dispatch(array_merge($u, $data));
// }

// function ship_logs_many(array $data){
//     return app()->make(\App\Contracts\Repositories\LogRepositoryInterface::class)->createMany($data);
//     //return RegistraLogJob::dispatch($data);
// }

// function ship_logs_debug($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_DEBUG, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_info($action, $origin, $description, int $codigo_usuario_modificado , int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_INFO, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_notice($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_NOTICE, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_warning($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_WARNING, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_error($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_ERROR, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_critical($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_CRITICAL, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_alert($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_ALERT, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }

// function ship_logs_emergency($action, $origin, $description, int $codigo_usuario_modificado, int $codigo_usuario){
//     return ship_logs(App\Services\LogService::LEVEL_EMERGENCY, $action, $origin, $description, $codigo_usuario_modificado, $codigo_usuario);
// }
