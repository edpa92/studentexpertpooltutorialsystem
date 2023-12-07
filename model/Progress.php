<?php
include_once('DbConnection.php');

class Progress {
    
    public $Progress="";
    public $TotalPercentageProgress=0;
    public $TotalNumberOfStudent=0;
    public $TotalStudPassers=0;
    
	
	public function __construct($prog, $totalProg, $totalStuds, $totalPassers){
		
		$this->Progress=$prog;
		$this->TotalNumberOfStudent=$totalStuds;
		$this->TotalPercentageProgress=$totalProg;
		$this->TotalStudPassers=$totalPassers;
	}
	
	
}