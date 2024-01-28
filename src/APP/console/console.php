<?php

namespace GillesPinchart\Ai\APP\console;

use Exception;

class console
{
    public mixed $argv;

    public function __construct($argv){
        $this->argv = $argv;
    }

    /**
     * @param array|null $argv
     * @return mixed|null
     */
    public function action(?array $argv = null): mixed
    {
        return $this->initCommand($argv??$this->argv)['action']??null;
    }

    public function param(int $num = 1): mixed
    {
        return $this->initCommand($argv??$this->argv)["parameters"][$num]??null;
    }

    /**
     * @throws Exception
     */
    public function command($callback): void
    {
        try {
            $callback();
        }
        catch (Exception $e){
            dd($e);
        }
    }
    /**
     * @param $arguments
     * @return array['metadata', 'parameters']
     */
    function initCommand($arguments): array
    {
        return [
            'action'    => $arguments[1]??null,
            'parameters'=>[
                1 => $arguments[2]??null,
                2 => $arguments[3]??null,
            ],
            'metadata'  => [
                'command_name'=>$arguments[0]??null
            ]
        ];
    }


    function streamTerminal($cmd): string
    {
        // TODO : à implémenter et tester
        $proc = popen($cmd, 'r');
        $data = '';
        while (!feof($proc)) {
            try{
                $echo = fread($proc, 4096);
                echo $echo ; // ."\r\n";

                $data .=$echo ."\r\n";
                file_put_contents("./stream_ai.txt", $data);
                // fwrite($proc, "TEST");
            }
            catch(Exception $e){
                dd($e->getMessage());
            }
        }
        pclose($proc);
        return $data;
    }
}