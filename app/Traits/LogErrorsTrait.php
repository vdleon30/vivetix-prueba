<?php
namespace App\Traits;


trait LogErrorsTrait
{
    public function reportError(\Exception $exception, string $type = "info"): void
    {
        if (!in_array($type, ["error", "info"])) {
            $type = "info";
        }
        \Log::$type("Ha ocurrido un error", [
            "error" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
            "code" => $exception->getCode(),
        ]);
    }

    public function reportErrorChannel(\Exception $exception, string $type = "info", string $channel =""): void
    {
        if (!in_array($type, ["error", "info"])) {
            $type = "info";
        }
        if (!in_array($channel, config("logging.channels"))) {
            $channel = config("logging.default");
        }
        \Log::channel($channel)->$type("Ha ocurrido un error", [
            "error" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
            "code" => $exception->getCode(),
        ]);
    }

    public function report(string $channel, string $type = "info", array $data = []): void
    {
        if (!in_array($channel, config("logging.channels"))) {
            $channel = config("logging.default");
        }

        if (!in_array($type, ["error", "info"])) {
            $type = "info";
        }
        \Log::channel($channel)->$type("Reporte de Seguimiento: ", $data);
    }
}
