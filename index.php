<?php

function how_many_gifts($x, $y, $z, $w) {
    if ($x < 0 || $y < 0 || $z < 0 || $w <= 0) {
        $result = "Enter x,y,z>=0 w>0";
    } else {
        $gifts = [$x, $y, $z]; 
        rsort($gifts); # sort the gifts in the array from high to low weight
        $result = 0;
        $n1 = ($w / $gifts[0]); # possible number of gifts with index 0
        for ($i = 0;$i <= $n1;$i++) { # cycle from 0 to n1
            $first = ($w - $i * $gifts[0]); # the total weight of the residue after placing first gift
            $n2 = ($first / $gifts[1]); # possible number of gifts with index 1, after placing first gift
            for ($k = 0;$k <= $n2;$k++) {
                $second = $first - $k * $gifts[1]; # the total weight of the residue after placing second gift
                if ($second % $gifts[2] == 0) { # determine the remainder when dividing by the third gift
                    $result++;
                }
            }
        }
    }
    return $result;
}

function time_to_copy($x, $y, $copies) {
    if ($x < 0 || $y < 0 || $copies < 0) {
        $result = "Enter x>=0,y>=0,copies>0";
    } elseif ($x == 0 || $y == 0) {
        $result = round($x * $copies + $y * $copies);
    } else {
        $tmp_time = [$x, $y];
        $min_time = min($tmp_time);
        $max_time = max($tmp_time);
        $index_delay = $max_time / $min_time; # determine how much slower the second printer
        $copies_on_slow = ($copies / ($index_delay + 1)); # the number of photocopies which will make slow Xerox
        $copies_on_faster = ($copies - $copies_on_slow); # the number of photocopies that will make faster Xerox
        $time_for_slow = $copies_on_slow * $max_time + $min_time; # time of slow Xerox
        $time_for_faster = $copies_on_faster * $min_time; # time of faster Xerox
        $match_time = [$time_for_faster, $time_for_slow];
        $result = round(max($match_time)); #full time to copy
    }
    return $result;
}

function count_friends($matrix, $n, $s) {
    $queue = [$s]; #an array of person number
    $used = [];
    $friends = [];
    for ($i = 1;$i <= $n;$i++) { 
        $used[] = false; #fill an array which will be responsible for the person we have already considered or not. "false"-not considered man
    }
    $used[$s - 1] = true;
    while (!empty($queue)) {
        $person = array_shift($queue); # pushes the first man from the queue ("the first came in, first-out"), transferring it to a variable.
        $person_row = $matrix[$person - 1]; # pull out a row of human friends
        for ($new_person = 1;$new_person <= $n;$new_person++) { # we take each person of row
            if ($person_row[$new_person - 1] == 1) { # if the expression is "true", do next
                if (!$used[$new_person - 1]) { # Check we take this person or nott . If the value "false", do next
                    $used[$new_person - 1] = true; # assigns a value to a friend - "true"
                    $queue[] = $new_person; # add to the queue a new friend
                }
            }
        }
    }
    foreach ($used as $index => $person) {
        if ($person) { # if person = true, do next
            $friends[] = $index + 1; # count all "true"
        }
    }
    return count($friends) - 1; # does not consider himself
}

echo ("=======================================================\n");
echo ("1. Candies\n");
echo ("Example:\n");
echo ("X=10; Y=25; Z=15; W=40\n");
echo ("Result: " . how_many_gifts(10, 25, 15, 40) . "\n");
echo ("=======================================================\n");
echo ("2. Secretary Jeniffer\n");
echo ("Example 1:\n");
echo ("X=1; Y=1; N=4;\n");
echo ("Result: " . time_to_copy(1, 1, 4) . "\n");
echo ("Example 2:\n");
echo ("X=1; Y=2; N=5;\n");
echo ("Result: " . time_to_copy(1, 2, 5) . "\n");
echo ("=======================================================\n");
echo ("3. Sloboda friends\n");
echo ("Example 1:\n");
$matrix = [[0, 1, 0], [1, 0, 1], [0, 1, 0]];
echo ("S=1; N=3; Matrix = " . json_encode($matrix) . "\n");
echo ("Result: " . count_friends($matrix, 3, 1) . "\n");
echo ("Example 2:\n");
$matrix = [[0, 0, 0, 0, 0], [0, 0, 1, 0, 0], [0, 1, 0, 0, 1], [0, 0, 0, 0, 1], [0, 0, 1, 1, 0]];
echo ("S=2; N=5; Matrix = " . json_encode($matrix) . "\n");
echo ("Result: " . count_friends($matrix, 5, 2) . "\n");
