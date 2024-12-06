<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Word;
use Illuminate\Support\Facades\Http;

class ImportWords extends Command
{

    protected $signature = 'words:import';

    protected $description = 'Importa palavras de uma API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $filePath = storage_path('app/words_dictionary.json');

        if (!file_exists($filePath)) {
            $this->error("Arquivo nao encontrado em {$filePath}");
            return Command::FAILURE;
        }

        try {
            
            $words = json_decode(file_get_contents($filePath), true);

            if (!is_array($words)) {
                $this->error("Formato inválido. Deveria ser JSON.");
                return Command::FAILURE;
            }

            // Importar palavras para o banco de dados
            foreach ($words as $word => $definition) {
                Word::updateOrCreate(
                    ['word' => $word],
                    ['definition' => $definition, 'synonyms' => json_encode([])]
                );
            }
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Aconteceu algum erro " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}