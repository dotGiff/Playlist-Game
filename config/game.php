<?php

return [
    'score_map' => [
        // [operator, rank, score, display, specialRound]
        ['==', 0, 0, 'Already knew', 0],
        ['==', 1, 5, 'Best song', 2.5],
        ['==', 2, 3, 'Second best', 1.5],
        ['==', 3, 2, 'Third best', 0],
        ['>=', 4, 1, 'Not top 3', 0],
    ]
];
