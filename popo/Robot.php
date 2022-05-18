<?php
/**
 * Robot class - used to interface with the user
 */
class Robot
{
	private $table;
	private $orientation;
	private $placed;
	private $faces = array(
		'NORTH' => 0,
		'EAST' 	=> 1,
		'SOUTH' => 2,
		'WEST' 	=> 3
	);

    /**
     * Robot constructor.
     */
	function __construct()
	{
		$this->table = new Table();
	}

    /**
     * Place the Bot on a table
     * @param string $location
     */
	public function place($location_str = '')
	{
		//used for validation - must be a valid place
		$this->placed = FALSE;
		$this->orientation = NULL;
        $location = explode(',', $location_str);
	    if(!$location || count($location) != 3)
        {
            $this->set_error('Please check your arguments for place()');
            return FALSE;
        }
		list($x, $y, $orientation) = $location;
		$moved = $this->table->make_move($x, $y);
		if($moved && $orientation && array_key_exists($orientation, $this->faces))
		{
			$this->orientation = $orientation;
			$this->placed = TRUE;
		}
		return $moved;
	}

    /**
     * Does the actual rotation
     * @param int $new_face
     * @return bool
     */
	private function rotate($new_face)
	{
		if($new_face > 3)
		{
			$new_face = 0;
		}
		elseif($new_face < 0)
		{
			$new_face = end($this->faces);
		}

		$valid_orientation = array_search($new_face, $this->faces);
		if($valid_orientation === FALSE)
		{
			//error
			return FALSE;
		}
		$this->orientation = $valid_orientation;
		return TRUE;
	}

    /**
     * rotate right
     * @return bool
     */
	public function right()
	{
		if(!$this->validate_placed()) return FALSE;

		$current_face = $this->faces[$this->orientation];
		$new_face = $current_face+1;
		$this->rotate($new_face);
	}

    /**
     * Rotate left
     * @return bool
     */
	public function left()
	{
		if(!$this->validate_placed()) return FALSE;

		$current_face = $this->faces[$this->orientation];
		$new_face = $current_face-1;
		$this->rotate($new_face);
	}

    /**
     * Take a step forward
     * @return bool
     */
	public function move($debug = FALSE)
	{
		if(!$this->validate_placed()) return FALSE;

		//Using a 'window', workout the direction to step
		$position = $this->table->get_position();
		$face_value = $this->faces[$this->orientation];

		$new_x = $position['x'];
		$new_y = $position['y'];

		if ($face_value % 2 == 0) 
		{
			$new_y = ($face_value == 0)? $position['y']+1 : $position['y']-1;
		}
		else
		{
			$new_x = ($face_value == 1)? $position['x']+1 : $position['x']-1;	
		}

		if ($debug == TRUE) 
		{
			echo '<pre>'.print_r(array(
				'position' => $position,
				'face_value' => $face_value,
				'new_x' => $new_x,
				'new_y' => $new_y), 
				TRUE).'</pre>';
		}

		return $this->table->make_move($new_x, $new_y);
	}

    /**
     * Output the pos
     * @outpu string
     */
	public function report()
	{
		if(!$this->validate_placed()) return FALSE;

		$position = $this->table->get_position();
		echo $position['x'].", ".$position['y'].", ".$this->orientation."<br/>";
	}

    /**
     * Check to see if we have a Bot in the table yet
     * @return bool
     */
	private function validate_placed()
	{
		if(!$this->placed)
		{
			$this->set_error('Not Placed');
			return FALSE;
		}
		return TRUE;
	}

	private function set_error($string = '')
	{
		echo 'ERROR: '.$string.'<br/>';
	}
}