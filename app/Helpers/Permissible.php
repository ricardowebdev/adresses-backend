<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

abstract class Permissible
{
    protected $_repo_perfil_permissao;

    public const LISTAR_PERFILS              = 'listar_perfils';
    public const CRIAR_PERFILS               = 'criar_perfils';
    public const EDITAR_PERFILS              = 'editar_perfils';
    public const REMOVER_PERFILS             = 'remover_perfils';
    public const LISTAR_CLIENTES             = 'listar_clientes';
    public const CRIAR_CLIENTES              = 'criar_clientes';
    public const EDITAR_CLIENTES             = 'editar_clientes';
    public const REMOVER_CLIENTES            = 'remover_clientes';
    public const LISTAR_PERMISSOES           = 'listar_permissoes';
    public const CRIAR_PERMISSOES            = 'criar_permissoes';
    public const EDITAR_PERMISSOES           = 'editar_permissoes';
    public const REMOVER_PERMISSOES          = 'remover_permissoes';
    public const LISTAR_PERFIL_PERMISSOES    = 'listar_perfil_permissoes';
    public const CRIAR_PERFIL_PERMISSOES     = 'criar_perfil_permissoes';
    public const EDITAR_PERFIL_PERMISSOES    = 'editar_perfil_permissoes';
    public const REMOVER_PERFIL_PERMISSOES   = 'remover_perfil_permissoes';
    public const LISTAR_USUARIOS             = 'listar_usuarios';
    public const CRIAR_USUARIOS              = 'criar_usuarios';
    public const EDITAR_USUARIOS             = 'editar_usuarios';
    public const REMOVER_USUARIOS            = 'remover_usuarios';
    public const LISTAR_CHAVES               = 'listar_chaves';
    public const CRIAR_CHAVES                = 'criar_chaves';
    public const EDITAR_CHAVES               = 'editar_chaves';
    public const REMOVER_CHAVES              = 'remover_chaves';
    public const COMANDOS_CHAVES             = 'comandos_chaves';
    public const LISTAR_GATEWAYS             = 'listar_gateways';
    public const CRIAR_GATEWAYS              = 'criar_gateways';
    public const EDITAR_GATEWAYS             = 'editar_gateways';
    public const REMOVER_GATEWAYS            = 'remover_gateways';
    public const LISTAR_LOGS                 = 'listar_logs';
    public const REMOVER_LOGS                = 'remover_logs';
    public const LISTAR_MEDIDAS              = 'listar_medidas';
    public const EDITAR_MEDIDAS              = 'editar_medidas';
    public const REMOVER_MEDIDAS             = 'remover_medidas';
    public const CRIAR_AGENDAMENTO_COMANDO   = 'criar_agendamento_comando';
    public const REMOVER_AGENDAMENTO_COMANDO = 'remover_agendamento_comando';
    public const EDITAR_AGENDAMENTO_COMANDO  = 'editar_agendamento_comando';
    public const LISTAR_AGENDAMENTO_COMANDO  = 'listar_agendamento_comando';
    public const LISTAR_REDELORA             = 'listar_redelora';
    public const CRIAR_REDELORA              = 'criar_redelora';
    public const EDITAR_REDELORA             = 'editar_redelora';
    public const REMOVER_REDELORA            = 'remover_redelora';
    public const LISTAR_TENANTS              = 'listar_tenants';
    public const LISTAR_APPLICATIONS         = 'listar_applications';
    public const EDITAR_PARAMETRIZACAO       = 'editar_parametrizacao';
    public const LISTAR_PARAMETRIZACAO       = 'listar_parametrizacao';
    public const SYNCRONIZAR_CHAVES          = 'sincronizar_chaves';
    public const SYNCRONIZAR_GATEWAYS        = 'sincronizar_gateways';
    public const LISTAR_CURTO_CIRCUITO       = 'listar_curto_circuito';
    Public const LISTAR_POTENCIA             = 'listar_potencia';
    public const LISTAR_PF                   = 'listar_pf';
    public const LISTAR_SINAL                = 'listar_sinal';
    public const LISTAR_IMPEDANCIA           = 'listar_impedancia';
    public const LISTAR_LORA_DATA            = 'listar_lora_data';
    public const ALTER_INTERVALO             = 'alter_intervalo';
    public const LISTAR_SOBRECORRENTE        = 'listar_sobrecorrente';

    static function hasAuth($permissao) : bool
    {
        $perfil = Auth::user()->id_perfil ?? 0;
        $permissao = app(\App\Repositories\PerfilPermissaoRepository::class)
            ->buscaPorPerfilPermissao($perfil, $permissao);

        return $permissao ? true : false;
    }
}
