<?php

//Bring in the app
include('application.php');

// And here we go!
$robot = new Robot();

echo '<marquee><h1>Robot Tests</h1></marquee>';

echo "<hr/>Example a<br/>";
$robot->place("0,0,NORTH");
$robot->move();
$robot->report();

echo "<hr/>Example b<br/>";
$robot->place("0,0,NORTH");
$robot->left();
$robot->report();

echo "<hr/>Example c<br/>";
$robot->place("1,2,EAST");
$robot->move();
$robot->move();
$robot->left();
$robot->move();
$robot->report();


echo '<marquee><h2>Dev Tests</h2></marquee>';
/*
	- The first valid command to the robot is a PLACE command, after that, any
  		sequence of commands may be issued, in any order, including another PLACE
  		command. The application should discard all commands in the sequence until
  		a valid PLACE command has been executed.
 */
echo "<hr/>TEST 1<br/>"; 
$robot->place("1,6,EAST"); //The toy robot must not fall off the table during movement. This also includes the initial placement of the toy robot.
$robot->move();
$robot->move();
$robot->left();
$robot->move();
$robot->report();

/*
	- The toy robot must not fall off the table during movement. This also includes the initial placement of the toy robot.
	- The first valid command to the robot is a PLACE command, after that, any
  		sequence of commands may be issued, in any order, including another PLACE
  		command. The application should discard all commands in the sequence until
  		a valid PLACE command has been executed.
 */
echo "<hr/>TEST 2<br/>";
$robot->place("4,3,EAST");
$robot->report();
$robot->move();
$robot->report();
$robot->move();
$robot->report();
$robot->left(); //LEFT and RIGHT will rotate the robot 90 degrees in the specified direction without changing the position of the robot.
$robot->report();
$robot->move();
$robot->report();
$robot->move();
$robot->report();
$robot->right();
$robot->right();
$robot->report(); // Should be South facing
$robot->move();
$robot->report(); // Should be  4 3 South
$robot->move();
$robot->move();
$robot->report(); // Should be  4 1 South
$robot->move();
$robot->report(); // Should be  4 0 South