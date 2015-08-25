<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/25/2015 AD
 * Time: 2:24 AM
 */

namespace lib;


class Generator
{
    private static $i = 0;
    private static $allfiles = 0;
    private static $sleeptime = 0;

    public static function test(){
        echo gethostbyname(gethostname()).PHP_EOL;
    }

    public static function create($command){
        $statement = $command[1].' '.$command[2].' '.$command[3];
        array_shift($command);
        array_shift($command);

        $cmd_string = implode(':',$command);
        $regex = "/^(project)[:]([a-zA-z][a-zA-z0-9]+)$|^(app)[:]([a-zA-z][a-zA-z0-9]+.[a-zA-z][a-zA-z0-9]*)$/";
        if(preg_match_all($regex,$cmd_string,$regex_output)){

            $type = $regex_output[1][0];
            $name = $regex_output[2][0];

            $type = $type == '' ? $regex_output[3][0] : $type;
            $name = $name == '' ? $regex_output[4][0] : $name;


            switch($type){
                case 'project':
                    $dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'dist'.DIRECTORY_SEPARATOR.$name;
                    if(file_exists($dir)){
                        fwrite(STDOUT,"\033[2J");

                        $header = 'Stirlingframe create error:';
                        $desc = '# Project `'.$name.'` already exists';
                        $msg = 'Change name or delete existing';

                        fwrite(STDOUT,Color::BOLD_RED.'[ERROR]: Project already exists.'.Color::RESET.PHP_EOL);
                        fwrite(STDOUT,Drawing::ERROR_BOX($header,$desc,$msg));

                        fwrite(STDOUT,PHP_EOL);
                    }else{
                        mkdir($dir);


                        $src = __DIR__.DIRECTORY_SEPARATOR.'includes/';


                        self::$i = 0;
                        self::$allfiles = self::count_files($src);
                        StopWatch::start();
                        self::recurse_copy($src,$dir,$name);
                        fwrite(STDERR,"\007");
                        fwrite(STDERR,PHP_EOL);

                        chdir('dist/'.$name);

                        fwrite(STDOUT,exec("php composer.phar install").PHP_EOL);
                        fwrite(STDOUT,exec("php composer.phar update").PHP_EOL);
                        $seconds = round(StopWatch::elapsed(),4);
                        chdir('../../');
                        fwrite(STDOUT,"\033[2J");
                        fwrite(STDOUT,Color::BOLD_GREEN.'[SUCCESS]: Project created.'.Color::RESET.PHP_EOL);
                        fwrite(STDOUT,Drawing::SUCCESS_BOX('Stirlingframe->Create:',
                            "# Project `$name` has been created.",
                            "# All files have been written in ".$seconds."s."));
                        fwrite(STDOUT,PHP_EOL);



                    }
                    break;
                case 'app':
                    $data = explode('.',$name);
                    $project = $data[0];
                    $controller = ucfirst($data[1]);



                    if(file_exists(dirname(dirname(__FILE__)) . '/dist/' . $project)) {


                        $write = true;
                        if(file_exists(dirname(dirname(__FILE__)) . '/dist/' . $project . '/app/controllers/' . strtolower($controller) . '.php')) {
                            $chk = true;
                            $confirm = "Are you sure you want to ".
                                Color::RED."overwrite controller".Color::RESET." `$controller` [no/yes]\033[5m?".Color::RESET.': ';
                            fwrite(STDOUT, "\033[2J");
                            fwrite(STDOUT, $confirm);
                            while($chk) {
                                $handle = fopen("php://stdin", "r");
                                $line = fgets($handle);
                                if (trim($line) != 'yes' and trim($line) != 'no') {
                                    fwrite(STDOUT, "\033[2J");

                                    fwrite(STDOUT, "Just type '" . Color::BOLD_GREEN . "yes'" . Color::RESET .
                                        " or '" . Color::BOLD_GREEN . "no'" . Color::RESET . PHP_EOL);

                                    fwrite(STDOUT, $confirm);
                                } else {
                                    $chk = false;
                                }
                            }

                            $write = trim($line) == 'yes';
                        }
                        if($write){
                            $str = file_get_contents(__DIR__ . '/templates/controller.template');
                            $str = str_replace('#NAME#', $controller, $str);
                            $str = str_replace('#LNAME#', strtolower($controller), $str);

                            //Write controller
                            $f = fopen(dirname(dirname(__FILE__)) . '/dist/' . $project . '/app/controllers/' . strtolower($controller) . '.php', "w");
                            fwrite($f, $str);
                            fclose($f);

                            //Write view
                            $str = file_get_contents(__DIR__ . '/templates/view.template');
                            $destview = dirname(dirname(__FILE__)) . '/dist/' . $project . '/app/views/' . strtolower($controller);
                            if(!file_exists($destview)){
                                mkdir($destview);
                            }
                            $f = fopen($destview.'/index.twig', "w");
                            fwrite($f, $str);
                            fclose($f);

                            fwrite(STDOUT,"\033[2J");
                            fwrite(STDOUT,Color::BOLD_GREEN.'[SUCCESS]: Controller and View created.'.Color::RESET.PHP_EOL);
                            fwrite(STDOUT,Drawing::SUCCESS_BOX('Stirlingframe->Create:',
                                "# Controller `$controller` has been created."));
                            fwrite(STDOUT,Color::BOLD_GREEN.'[URL]:'.Color::BOLD_CYAN.' http://localhost/dist/'.$project.'/'.strtolower($controller).Color::RESET.PHP_EOL);
                            fwrite(STDOUT,PHP_EOL);

                        }else{
                            fwrite(STDOUT, "\033[2J");
                            fwrite(STDOUT, '[ABORTED]: '.Color::BOLD_UNDERLINE."Nothing is changed.".Color::RESET.PHP_EOL.PHP_EOL);
                        }
                    }else{
                        $msg  = 'please check your project name';
                        fwrite(STDOUT,"\033[2J");
                        fwrite(STDOUT,Color::BOLD_RED.'[ERROR]: Project `'.Color::BOLD_MEGENTA.$project.Color::BOLD_RED.'` not exist'.Color::RESET.PHP_EOL);
                        fwrite(STDOUT,Color::BOLD_RED.'# '.Color::RESET.$statement.PHP_EOL);
                        fwrite(STDOUT,Drawing::ERROR_BOX('Stirlingframe error: project not exist',$msg));
                        fwrite(STDOUT,PHP_EOL);
                    }
                    break;
            }
        }
        else{
            $msg  = Color::CYAN.'$'.Color::RESET.' create [project] [name]                   ';
            $msg2 = Color::CYAN.'$'.Color::RESET.' create [app] [project.controller]         ';
            fwrite(STDOUT,"\033[2J");
            fwrite(STDOUT,Color::BOLD_RED.'[ERROR]: Invalid command.'.Color::RESET.PHP_EOL);
            fwrite(STDOUT,Color::BOLD_RED.'# '.Color::RESET.$statement.PHP_EOL);
            fwrite(STDOUT,Drawing::ERROR_BOX('Stirlingframe error: command should be',$msg,$msg2));
            fwrite(STDOUT,PHP_EOL);
        }
    }

    public static function delete($command){
        array_shift($command);
        array_shift($command);

        $cmd_string = implode(':',$command);
        if(preg_match_all("/^(project|app)[:]([a-zA-z][a-zA-z0-9]+)$/",$cmd_string,$regex_output)){
            $type = $regex_output[1][0];
            $name = $regex_output[2][0];
            switch($type){
                case 'project':
                    $dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'dist'.DIRECTORY_SEPARATOR.$name;
                    if(file_exists($dir)){
                        $chk = true;
                        $confirm = "Are you sure you want to ".
                            Color::RED."delete".Color::RESET." `$name` [no/yes]\033[5m?".Color::RESET.': ';
                        fwrite(STDOUT, "\033[2J");
                        fwrite(STDOUT, $confirm);
                        while($chk) {
                            $handle = fopen("php://stdin", "r");
                            $line = fgets($handle);
                            if (trim($line) != 'yes' and trim($line) != 'no') {
                                fwrite(STDOUT, "\033[2J");

                                fwrite(STDOUT, "Just type '" . Color::BOLD_GREEN . "yes'" . Color::RESET .
                                    " or '" . Color::BOLD_GREEN . "no'" . Color::RESET . PHP_EOL);

                                fwrite(STDOUT, $confirm);
                            } else {
                               $chk = false;
                            }
                        }

                        if(trim($line) == 'no'){
                            fwrite(STDOUT, "\033[2J");
                            fwrite(STDOUT, '[ABORTED]: '.Color::BOLD_UNDERLINE."Nothing is deleted.".Color::RESET.PHP_EOL.PHP_EOL);
                        }else{

                            self::$i = 0;
                            self::$allfiles = self::count_files($dir.'/');

                            StopWatch::start();
                            self::rrmdir($dir);
                            $seconds = round(StopWatch::elapsed(),4);

                            fwrite(STDERR,"\007");
                            fwrite(STDERR,PHP_EOL);

                            fwrite(STDOUT,"\033[2J");
                            fwrite(STDOUT,Color::BOLD_GREEN.'[SUCCESS]: Project deleted.'.Color::RESET.PHP_EOL);
                            fwrite(STDOUT,Drawing::SUCCESS_BOX('Stirlingframe->Delelte:',
                                "# Project `$name` has been delete.",
                                "# ".self::$allfiles." files have been removed in ".$seconds."s."));
                            fwrite(STDOUT,PHP_EOL);

                        }


                    }else{

                        fwrite(STDOUT,"\033[2J");

                        $header = 'Stirlingframe delete error:';
                        $desc = '# Project `'.$name.'` not exist';

                        fwrite(STDOUT,Color::BOLD_RED.'[ERROR]: Can\'t delete project.'.Color::RESET.PHP_EOL);
                        fwrite(STDOUT,Drawing::ERROR_BOX($header,$desc));

                        fwrite(STDOUT,PHP_EOL);
                    }
                    break;
                case 'app':
                    fwrite(STDOUT,'$create '.$type.' '.$name.PHP_EOL);
                    break;
            }
        }else{
            $msg = Color::CYAN.'$'.Color::RESET.' delete [project|app] [name]               ';
            fwrite(STDOUT,"\033[2J");
            fwrite(STDOUT,Color::BOLD_RED.'[ERROR]: Invalid command.'.Color::RESET.PHP_EOL);
            fwrite(STDOUT,Drawing::ERROR_BOX('Stirlingframe create error:','# Invalid parameters: command should be',$msg));
            fwrite(STDOUT,PHP_EOL);
        }
    }

    private static function recurse_copy($src,$dst,$name) {
        $dir = opendir($src);
        @mkdir($dst);

        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    self::recurse_copy($src . '/' . $file,$dst . '/' . $file,$name);
                }
                else {

                    $filename = $src . '/' . $file;

                    if($file == 'app.php'){
                        $str = file_get_contents(__DIR__.'/templates/config/app.template');
                        $str = str_replace('#NAME#',$name,$str);
                        $f =fopen($dst . '/' . $file, "w");
                        fwrite($f, $str);
                        fclose($f);
                    }
                    else if($file == 'home.php'){
                        $str = file_get_contents(__DIR__.'/templates/homecontroller.template');
                        $str = str_replace('#NAME#',$name,$str);
                        $f =fopen($dst . '/' . $file, "w");
                        fwrite($f, $str);
                        fclose($f);
                    }
                    else{
                        copy($filename, $dst . '/' . $file);
                    }

                    fwrite(STDOUT,"\0337");
                    $percent = round((self::$i * 100)/self::$allfiles,2);
                    $step = $percent/10;
                    fwrite(STDERR,"\0338");

                    if($percent < 25){
                        $color = Color::RED;
                    }
                    if($percent >= 25 and $percent < 50){
                        $color = Color::YELLOW;
                    }
                    if($percent >= 50 and $percent < 75){
                        $color = Color::BOLD_CYAN;
                    }
                    if($percent >= 75){
                        $color = Color::GREEN;
                    }

                    fwrite(STDERR,"Writing file: ". $dst . '/' . $file.PHP_EOL);
                    fwrite(STDERR,"\033[1A");

                    fwrite(STDERR,"Copy file: $color [".str_repeat('#',$step).str_repeat('.',10-$step).']'.Color::RESET);
                    fwrite(STDOUT," {$percent}% Complete".PHP_EOL);
                    fwrite(STDERR,"\033[1A");
                    usleep(self::$sleeptime);

                    self::$i++;
                }
            }
        }
        closedir($dir);
    }

    private static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") {
                        self::rrmdir($dir . "/" . $object);
                    }
                    else {
                        unlink($dir . "/" . $object);

                        fwrite(STDOUT,"\0337");
                        $percent = round((self::$i * 100)/self::$allfiles);
                        $step = $percent/10;
                        fwrite(STDERR,"\0338");

                        if($percent < 25){
                            $color = Color::RED;
                        }
                        if($percent >= 25 and $percent < 50){
                            $color = Color::YELLOW;
                        }
                        if($percent >= 50 and $percent < 75){
                            $color = Color::BOLD_CYAN;
                        }
                        if($percent >= 75){
                            $color = Color::GREEN;
                        }

                        fwrite(STDERR,"Remove file: $dir".PHP_EOL);
                        fwrite(STDERR,"\033[1A");
                        fwrite(STDERR,"Delete file: $color [".str_repeat('#',$step).str_repeat('.',10-$step).']'.Color::RESET);
                        fwrite(STDOUT," {$percent}% Complete".PHP_EOL);
                        fwrite(STDERR,"\033[1A");
                        usleep(self::$sleeptime);

                        self::$i++;
                    };
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    private static function count_files($path) {


        $file_count = 0;

        $dir_handle = opendir($path);

        if (!$dir_handle) return -1;

        while ($file = readdir($dir_handle)) {

            if ($file == '.' || $file == '..') continue;

            if (is_dir($path . $file)){
                $file_count += self::count_files($path . $file . DIRECTORY_SEPARATOR);
            }
            else {
                $file_count++;
            }
        }

        closedir($dir_handle);

        return $file_count;
    }
}