<?php
include('Labyrinth/Base.php');
include('Labyrinth/Solver.php');

$labyrinth = new Labyrinth_Base();

$solver = new Labyrinth_Solver($labyrinth);
$solver->solve();

echo $labyrinth->render();