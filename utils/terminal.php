<?php
include 'utils.php';
$time = new Timer;
$file = $_POST['file'];
$mode = $_POST['mode'];
$redirstream = ' 2>&1 ';
$pathprefix = '../projects/';
function setProgram($file,$mode){
    $ext = pathinfo($file,PATHINFO_EXTENSION);
    if($mode == 'Compile'){
        if($ext=='c' || $ext=='c++' || $ext=='cc' || $ext=='cpp' || $ext=='cxx')
            return 'g++';
        elseif($ext=='java')
            return 'javac';
    }
    elseif($mode=='Run'){
        if($ext=='exe')
            return '';
        else if($ext=='class')
            return 'java';
        else if($ext=='py' || $ext=='pyw' || $ext=='pyc' || $ext=='pyo' || $ext=='pyd')
            return 'python';
    }
}

if(isset($file) && $mode=='Compile'){
    $command='';
    if(setProgram($file,$mode)=='g++'){
        $command = setProgram($file,$mode).' "'.$pathprefix.$file.'" -o "'.pathinfo($pathprefix.$file,PATHINFO_DIRNAME).'/'.pathinfo($file,PATHINFO_FILENAME).'"'.$redirstream;
    }
    elseif(setProgram($file,$mode)=='javac'){
        $command = setProgram($file,$mode).' '.$pathprefix.$file.$redirstream;
    }
        
    $time->start();
    $output = shell_exec($command);
    $elapsed = $time->stop();
    
    if(strlen($output)<1)
        echo "File Successfully Compiled in ",$elapsed," seconds";
    else{
        /****Need to add some REGEX to prevent any host system information being exposed***/
        echo '<pre>',$output,'</pre></br>Took ',$elapsed,' seconds';
    }
}

elseif(isset($file) && $mode=='Run'){
    if(setProgram($file,$mode)=='' || setProgram($file,$mode)=='python'){
        $command = setProgram($file,$mode).' '.escapeshellarg($pathprefix.$file).$redirstream;
    }
    elseif(setProgram($file,$mode)=='java')
        $command = setProgram($file,$mode).' -cp '.escapeshellarg(pathinfo($pathprefix.$file,PATHINFO_DIRNAME)).' '.pathinfo($file,PATHINFO_FILENAME).$redirstream;
    
    $time->start();
    $output = shell_exec($command);
    $elapsed = $time->stop();
    echo '<pre>',$output,'</pre></br>Took ',$elapsed,' seconds';
}

else{
    echo 'File not found/mode not supported';
}
?>
