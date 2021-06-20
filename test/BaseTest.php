<?php

namespace Test;

class BaseTest
{
    /**
     * @var int
     */
    private int $testCount = 0;

    /**
     * @var int
     */
    private int $passedCount = 0;

    /**
     * @param $result
     * @param $expected
     */
    public function assert($result, $expected = true) {
        if($result == $expected){
            $this->passedCount++;
        }
        $this->testCount++;
    }

    /**
     * @return int
     */
    public function getTestCount(): int {
        return $this->testCount;
    }

    /**
     * @return int
     */
    public function getPassedCount(): int {
        return $this->passedCount;
    }

    /**
     * @return int
     */
    public function getFailedCount(): int {
        return $this->testCount - $this->passedCount;
    }
}
