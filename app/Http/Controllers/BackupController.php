<?php

namespace ConfiSis\Http\Controllers;

use Illuminate\Http\Request;

use ConfiSis\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;
use Symfony\Component\Process\Process;
use DB;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
$con = mysqli_connect("localhost","root","","mwabd");

$tables = array();
$query = mysqli_query($con, 'SHOW TABLES');
while($row = mysqli_fetch_row($query)){
     $tables[] = $row[0];
}

$result = "";
foreach($tables as $table){
$query = mysqli_query($con, 'SELECT * FROM '.$table);
$num_fields = mysqli_num_fields($query);

$result .= 'DROP TABLE IF EXISTS '.$table.';';
$row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE '.$table));
$result .= "\n\n".$row2[1].";\n\n";

for ($i = 0; $i < $num_fields; $i++) {
while($row = mysqli_fetch_row($query)){
   $result .= 'INSERT INTO '.$table.' VALUES(';
     for($j=0; $j<$num_fields; $j++){
       $row[$j] = addslashes($row[$j]);
       $row[$j] = str_replace("\n","\\n",$row[$j]);
       if(isset($row[$j])){
		   $result .= '"'.$row[$j].'"' ; 
		}else{ 
			$result .= '""';
		}
		if($j<($num_fields-1)){ 
			$result .= ',';
		}
    }
   	$result .= ");\n";
}
}
$result .="\n\n";
}

	//Create Folder
	$folder = 'Backup_Files/';
	if (!is_dir($folder))
	mkdir($folder, 0777, true);
	chmod($folder, 0777);

	$date = date('m-d-Y'); 
	$filename = $folder."db_backup_".$date; 

	$handle = fopen($filename.'.sql','w+');
	fwrite($handle,$result);
	fclose($handle);
	
	return Redirect::to('home');
    }
}
