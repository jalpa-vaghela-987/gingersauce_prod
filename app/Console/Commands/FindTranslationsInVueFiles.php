<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FindTranslationsInVueFiles extends Command
{
    protected $signature = 'translations:findvue';

    protected $description = 'Find translations in Vue JS files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $files = \File::allFiles('resources/js/components');
        $vueFiles = [];

        foreach($files as $file){
            if($file->getExtension() == 'vue'){
                $vueFiles[] = $file->getRealPath();
                $this->info($file->getRealPath());
            }
        }

        $pattern = "/translate\(\'[a-zA-Z0-9,.:<>\/? ]+'\)/";

        foreach($vueFiles as $file){
            $data = file_get_contents($file);
            $matches = [];
            $res = [];
            preg_match_all($pattern, $data, $matches);

            foreach($matches[0] as $match){ 
                $edit = str_replace(array("translate('","')"), '', $match); 
                $this->info($edit);
                $res[] = $edit;
            }
        }
        $problems = [];
        foreach($res as $line){
            if(is_string($line)){
                $this->info($line);
            }else{
                $problems[] = $line;
            }
        }

        $this->error(json_encode($problems));


    }
}
