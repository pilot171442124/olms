
<?php
echo "<pre>";

echo "Time zone <br/>";
echo date_default_timezone_get()."<br/>";
echo date("Y-m-d H:i:s")."<br/>";
 
echo "OS information <br/>";
echo PHP_OS . "<br/>";;

echo PHP_SHLIB_SUFFIX . "<br/>";;
/* 
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo 'This is a server using Windows!';
} else {
    echo 'This is a server not using Windows!';
} */

$output = shell_exec('date'); 
echo "<pre>$output</pre>";

// $output = shell_exec('ls -lS');
$output = shell_exec('ls -l /home/talukder/public_html/demo'); //under directory
// $output = shell_exec('ls -ld /files'); //under directory
// $output = shell_exec('ls -i');
echo "<pre>$output</pre>";

// exit;




// echo getcwd();// find folder directory.  /home/talukder/public_html/demo
// no35M . 26M ./files 9.2M ./spa.zip 8.0K ./Interoprabilitydhis2.zip 4.0K ./shell.php 

if(is_dir("/home/talukder/public_html/demo/error_log")){
	echo "yes";
}
else
	echo "no";
// exit;

echo "<br/>File permission <br/>";
// $output = shell_exec('ls | wc -l');
// $output = shell_exec('du -a -h --max-depth=1 /home/talukder/public_html/demo | sort -hr');
$output = shell_exec('du -a -h --max-depth=1 /home/talukder/public_html/demo');
echo $output;
// 35M	/home/talukder/public_html/demo
// 26M	/home/talukder/public_html/demo/files
// 9.2M	/home/talukder/public_html/demo/spa.zip
// 8.0K	/home/talukder/public_html/demo/Interoprabilitydhis2.zip
// 4.0K	/home/talukder/public_html/demo/shell.php
// 4.0K	/home/talukder/public_html/demo/error_log


// exit;

//show file count from location
echo "<br/>File count of a location <br/>";
$output = shell_exec('ls /home/talukder/public_html/demo | wc -l');
echo "<pre>$output</pre>";


// exit;
echo "File permission <br/>";
$output = shell_exec('stat -c "%a" /home/talukder/public_html/demo/shell.php');
echo "<pre>$output</pre>";



// $output = shell_exec('du -h --max-depth=0 * | sort -hr');
$output = shell_exec('du -a -h --time --max-depth=1 | sort -hr');
echo "<pre>$output</pre>";
// exit;

$data = explode("\n", $output);
foreach($data as $value){
	
	$data1 = explode("./", $value);
	print_r($data1);
}
// [0] => 9.2M	./spa.zip

// $out = "<pre>$output</pre>";

// foreach($out as $val){
	// print_r($val);
// }
// echo ($out);


// echo "<pre>$output</pre>";
echo "File permission <br/>";
$output = shell_exec('du -a -h --all | sort -hr');
echo "<pre>$output</pre>";



/* echo "<pre>";
function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
	// print_r($files);
	
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
		
		  echo $path."<br/>";
		
        if (!is_dir($path)) {
            $results[] = $path;
			echo filesize($path)."<br/>";
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
			echo filesize($path)."<br/>";
        }
    }

    return $results;
}

print_r(getDirContents('D:\xampp\htdocs\php'));
 */
?>
