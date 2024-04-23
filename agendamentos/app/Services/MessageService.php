<?php
namespace App\Services;

class MessageService {
    public function prepareUpdateMessages($changes, $exception = null) {
        if (empty($changes)) {
            return ['type' => 'info', 'message' => 'Não há nada para ser atualizado.'];
        }

        if ($exception) {
            return ['type' => 'error', 'message' => 'Falha ao atualizar o registro: ' . $exception->getMessage()];
        }

        return ['type' => 'success', 'message' => 'Registro atualizado com sucesso.'];
    }
}
