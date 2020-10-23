<?php

return [
    'itemsPerPage' => 15,

    /**
     * tentativas de um item na fila
     */
    'attemptQueue' => 3,

    /**
     * tentativas de retoken caso ocorra 401 ou 403 na integração
     */
    'attemptReToken' => 3,

    /**
     * Indica onde sera a persistencia das configurações :
     */
    'persistenceConfiguration' => 'mongodb',
];
