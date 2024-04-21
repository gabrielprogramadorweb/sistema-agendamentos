<?php
namespace App\Services;

abstract class MyBaseService
{
    /**
     * Método genérico para capturar exceções e tratar erros de forma padronizada.
     */
    protected function handleExceptions(callable $fn)
    {
        try {
            return $fn();
        } catch (\Exception $e) {
            // Aqui você pode logar o erro, enviar para um serviço de monitoramento, etc.
            \Log::error($e->getMessage());
            throw new \Exception("An error occurred, please try again later.");
        }
    }

    /**
     * Exemplo de método que pode ser comum para recuperar todos os registros de um modelo
     */
    protected function getAll($model)
    {
        return $model::all();
    }
}
