<?php
namespace App\Services;

abstract class MyBaseService
{
    /**
     * Método genérico para capturar exceções e tratar erros de forma padronizada.
     */
    // Elemento HTML a ser exibido caso não haver dados
    public const TEXT_FOR_NO_DATA = '<div class="text-info">Não há dados para serem exibidos</div>';
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

    public static function formatDateTime($dateTime)
    {
        // Formata a data e hora para o formato desejado (data brasileira, hora e minuto)
        return $dateTime->format('d/m/Y H:i');
    }

    /**
     * Exemplo de método que pode ser comum para recuperar todos os registros de um modelo
     */
    protected function getAll($model)
    {
        return $model::all();
    }
}
