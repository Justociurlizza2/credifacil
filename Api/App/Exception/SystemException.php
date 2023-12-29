<?php
namespace App\Exception;
use App\Exception\Matcher;
use Controllers\Helper;

enum Frames {
    case PRIVACYCLASS;
    case PRIVACYMETHOD;
    case PROTECTEDMETHOD;
    public function printer(string $param = ''): string
    {
        return match ($this) 
        {
            self::PRIVACYCLASS   => 'DENEGADO: Servicio prohibido',
            self::PRIVACYMETHOD  => 'DENEGADO: Procedimiento privado',
            self::PROTECTEDMETHOD=> 'DENEGADO: Procedimiento protegido'
        };
    }
}
class SystemException extends \Exception implements IBretsiaException
{
    private string $customMessage;
    public function __construct(private \Throwable $tw) 
    {
        $this->customMessage = $tw->getMessage();
        $this->matchErrorException();
        $this->errorMessage();
    }
    public function errorMessage(): void
    {
        helper::http($this->customMessage, 405);
    }
    public function matchErrorException(): void
    {
        $clean = Matcher::clean($this->customMessage, '\\');
        $match = Matcher::match($clean);
        $this->customMessage = match ($match) {
            'Call'              => Frames::PRIVACYCLASS->printer(),
            'private method'    => Frames::PRIVACYMETHOD->printer(),
            'protected method'  => Frames::PROTECTEDMETHOD->printer(),
            default => $clean
        };
    }
}
// "Call to protected method App\\Factory\\AccountFactory\\StandardManager::migrate() from scope App\\Repository\\RouterRepository\\PutRouter"