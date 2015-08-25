<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/25/2015 AD
 * Time: 11:52 PM
 */

namespace lib;


class Server
{
    public static function runserver($command){
        array_shift($command);
        array_shift($command);
        $cmd_string = implode(':',$command);

        $regex = "/^([a-zA-Z_][a-zA-Z0-9_]*[a-zA-Z0-9])$/";
        if(preg_match_all($regex,$cmd_string,$regex_output)){
            $project = $regex_output[0][0];
            if(file_exists('dist/'.$project)) {

                fwrite(STDOUT,"\033[2J");
                fwrite(STDOUT,Color::BOLD_GREEN.'[RUNNING PROJECT]: '.$project.Color::RESET.PHP_EOL);
                fwrite(STDOUT,"url-> ".Color::UNDERLINE_BLUE."http://localhost:9000".Color::RESET.PHP_EOL);
                fwrite(STDOUT,Drawing::SUCCESS_BOX('Stirlingframe->Run server:',
                    "# Project `$project` is running",
                    "# Press Ctrl + c to stop running"));
                fwrite(STDOUT,PHP_EOL);

                chdir('dist/' . $project);
//                exec("open http://localhost:9000");
                exec('php -S localhost:9000');

            }else{
                fwrite(STDOUT,"\033[2J");

                $header = 'Stirlingframe run error:';
                $desc = '# Project `'.$project.'` not exist';

                fwrite(STDOUT,Color::BOLD_RED.'[ERROR]: unable to run project.'.Color::RESET.PHP_EOL);
                fwrite(STDOUT,Drawing::ERROR_BOX($header,$desc));

                fwrite(STDOUT,PHP_EOL);
            }

        }
    }
}