<?php

namespace App\Enums;


enum Games2ApiErrorsEnum : string {
    case INVALID_METHOD = 'O método de solicitação é inválido';
    case INVALID_PARAMETER = 'O parâmetro de solicitação é inválido';
    case INVALID_AGENT = 'Agente é inválido';
    case INVALID_AGENT_ROLE = 'A função de agente é inválida';
    case BLOCKED_AGENT = "Agente está bloqueado";
    case INVALID_USER = "O usuário é inválido";
    case INSUFFICIENT_AGENT_FUNDS = "O equilíbrio do agente não é suficiente";
    case INSUFFICIENT_USER_FUNDS = "O saldo do usuário não é suficiente";
    case DUPLICATED_USER = "O código do usuário é duplicado";
    case INVALID_PROVIDER = "O provedor é inválido";
    case INTERNAL_ERROR = "Erro do servidor interno";
    case EXTERNAL_ERROR = "Erro de servidor externo";
    case API_CHECKING = "API agora está checando";
    case AGENT_SEAMLESS = "Agent Seamless Error";
}
