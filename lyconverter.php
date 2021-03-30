<?php

class LYConverter {
	public $rootdir;

	function scanDirs($directory) {
		chdir($directory);
		$fl=scandir(getcwd());
		foreach($fl as $f) {
			if($f!="."&&$f!="..") {
				if(is_dir($f)) {
					$this->scanDirs($f);
				}
				else {
					$info = new SplFileInfo($f);
					$extension=$info->getExtension();
					$fnpur=$info->getBasename(".$extension");
					$fnnew="$fnpur-new.$extension";
					if($extension=="ly"||$extension=="ily") {
						$command="convert-ly $f > $fnnew";
						echo "\n-----\n".getcwd()."\nKommando: ".$command."\n";
						shell_exec($command);
						$info_n=new SplFileInfo($fnnew);
						$size=$info_n->getSize();
						if($size>0) {
							rename($fnnew,$f);
						}
					}
				}
			}
		}
		chdir("..");
	}
	
	function __construct($directory) {
		$this->rootdir=$directory;
		$this->scanDirs($directory);
	}
}