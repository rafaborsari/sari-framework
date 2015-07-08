<?php 
/* 
Controller Interface
*/
interface ControllerInterface
{
	/*
	Action Title, define title and description page
	*/
	public function title();

	/*
	Action Main, standard page
	*/
	public function main();
}