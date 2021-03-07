<?php

function fizzbuzz($n = 100) {
	for ($i = 1; $i < $n; $i++) {
    	echo match(0) {
        	$i % 15 => 'fizzbuzz',
          	$i % 5 => 'buzz',
        	$i % 3 => 'fizz',
          	default => $i
        };
      	echo PHP_EOL;
    }
}

fizzbuzz();