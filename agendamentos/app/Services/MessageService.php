<?php
namespace App\Services;

class MessageService {
    public function prepareCreateMessages(\Exception $e = null) {
        if ($e === null) {
            return [
                'type' => 'success',
                'message' => '<i class="fa fa-check-circle"></i> Registro criada com sucesso.'
            ];
        } else {
            return [
                'type' => 'error',
                'message' => '<i class="fa fa-exclamation-circle"></i> ' . $this->formatExceptionMessage($e)
            ];
        }
    }

    public function prepareExcluirMessages(\Exception $e = null) {
        if ($e === null) {
            return [
                'type' => 'success',
                'message' => '<i class="fa fa-check-circle"></i> Unidade excluída com sucesso.'
            ];
        } else {
            return [
                'type' => 'error',
                'message' => '<i class="fa fa-exclamation-circle"></i> ' . $this->formatExceptionMessage($e)
            ];
        }
    }


    public function prepareActiveMessages($isActive, \Exception $e = null) {
        if ($e === null) {
            return [
                'type' => 'success',
                'message' => '<i class="fa fa-check-circle"></i> ' . ($isActive ? 'Unidade ativada com sucesso.' : 'Unidade desativada com sucesso.')
            ];
        } else {
            return [
                'type' => 'error',
                'message' => '<i class="fa fa-exclamation-circle"></i> ' . $this->formatExceptionMessage($e)
            ];
        }
    }


    public function prepareUpdateMessages($changes, \Exception $e = null) {
        if ($e === null && empty($changes)) {
            return [
                'type' => 'info',
                'message' => 'Não há nada para ser atualizado.'
            ];
        } elseif ($e !== null) {
            return [
                'type' => 'error',
                'message' => $this->formatExceptionMessage($e)
            ];
        } else {
            return [
                'type' => 'success',
                'message' => 'Registro atualizada com sucesso.'
            ];
        }
    }



    private function formatExceptionMessage(\Exception $e) {
        // Custom formatting can be enhanced here as needed
        return 'Falha ao processar a solicitação: ' . $e->getMessage();
    }

}
