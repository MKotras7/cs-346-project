<?php
    class myRng
    {
        private $seed;
        function __construct($seed)
        {
            $this->seed = hash("sha256", $seed);
        }

        function getValue()
        {
            return hexdec(substr($this->seed,0,8)) ;
        }

        function nextRandom()
        {
            $this->seed = hash("sha256", $this->seed);
        }
    }

    /*
    class Board
    {
        private $size;
        private $players;
        private $iterationNum;
        private $seed;

        function __construct()
        {
            $this->size = 20;
        }

        function getSize()
        {
            return $this->size;
        }
    }
    */

    /*
    $rng = new myRng(microtime());
    for($i = 0; $i < 10; $i++)
    {
        echo "<div>".($rng->getValue())."</div>";
        $rng->nextRandom();
    }
    echo "asasdd";
    */
?>
