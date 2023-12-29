<?php
namespace App\Strategy\WriterStrategy;
use App\Strategy\WriterStrategy\WriterStrategy;
use Controllers\Helper;

class SystemWriter
{
    private WriterStrategy $writerStrategy;
    public function __construct (private $file, private String $format, private $params = [])
    {
        date_default_timezone_set('America/Mexico_City');
        if(!in_array($this->format, ['Json', 'Txt', 'Log', 'SPenvio'])) 
        Helper::HttpResponse(['rs' => $format.'Writer do not supported']);
        $this->getStrategy();
    }
    public function getStrategy (): void
    {
        $instance = "App\\Strategy\\WriterStrategy\\".$this->format."Writer";
        $this->writerStrategy = new $instance($this->file, $this->params);
    }
    public function setStrategy($file, String $format, $params = []): void
    {
        $this->file = $file;
        $this->format = $format;
        $this->params = $params;
        $this->getStrategy();
    }
    public function convert ()
    {
        return $this->writerStrategy ->convert();
    }
    public function produce ()
    {
        return $this->writerStrategy ->produce();
    }
    public function save ($route)
    {
        return $this->writerStrategy ->save($route);
    }
    public function getSavedFile($path): string
    {
        $file = file_get_contents($path);
        return $file;
    }
    public function routeTimestamp () : string
    {
        $path = explode('/', $this->route);
        $name = array_pop($path);
        $time = date('d-m-y H:i:s');
        $time = str_replace(':', '', $time);
        $time = str_replace('-', '', $time);
        $title = $name.str_replace(' ', '_', $time);
        $path = implode('/', $path);
        return $path.'/'.$title;
    }
}