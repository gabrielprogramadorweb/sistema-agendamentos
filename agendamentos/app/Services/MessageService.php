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

    public function prepareCreateMessages($exception = null)
    {
        if ($exception) {
            \Log::error("Error creating unit: " . $exception->getMessage());
            return [
                'type' => 'error',
                'message' => 'Falha ao criar unidade..'
            ];
        }

        return [
            'type' => 'success',
            'message' => 'Unidade criada com sucesso.'
        ];
    }
}
