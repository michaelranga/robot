<?php
/**
 * Table class - only used in the robot class 
 */
class Table
{
	private $x = 5;
	private $y = 5;
	private $currently_occupied = array('x' => 0, 'y' => 0);
	private $error;

    /**
     * Table constructor.
     * @param null $new_x
     * @param null $new_y
     */
	function __construct($new_x = NULL, $new_y = NULL)
	{
		if($new_x) $this->x = $new_x;
		if($new_y) $this->y = $new_y;
	}

    /**
     * Let the table know about the move
     * @param int $x
     * @param int $y
     * @return bool
     */
	public function make_move($x = NULL, $y = NULL)
	{
		if(!is_numeric($x) || !is_numeric($y))
		{
			$this->set_error('Invalid @prams in make_move()');
			return FALSE;
		}
		if($x < 0 || $y < 0 || $x >= $this->x || $y >= $this->y)
		{
			$this->set_error('make_move() out of bounds');
			return FALSE;
		}
		$this->currently_occupied['x'] = $x;
		$this->currently_occupied['y'] = $y;
		return TRUE;
	}

    /**
     * Get the current position
     * @return array
     */
	public function get_position()
	{
		return $this->currently_occupied;
	}

    /**
     * Just a method to set some errors - best to write
     * @param string $string
     */

	private function set_error($string = '')
	{
		echo 'ERROR: '.$string.'<br/>';
	}
}