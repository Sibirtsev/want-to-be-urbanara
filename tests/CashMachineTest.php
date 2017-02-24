<?php
declare(strict_types=1);

namespace Sibirtsev\Urbanara;

use PHPUnit\Framework\TestCase;

class CashMachineTest extends TestCase
{
    public function testCreateCacheMachine()
    {
        $cache_machine = new CashMachine();
        $this->assertTrue($cache_machine instanceof CashMachine);
        $this->assertEquals([100, 50, 20, 10], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithCustomNotes()
    {
        $cache_machine = new CashMachine([10, 5, 3]);
        $this->assertTrue($cache_machine instanceof CashMachine);
        $this->assertEquals([10, 5, 3], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithCustomOrderedNotes()
    {
        $cache_machine = new CashMachine([1, 3, 2]);
        $this->assertTrue($cache_machine instanceof CashMachine);
        $this->assertEquals([3, 2, 1], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithBadNotes()
    {
        $cache_machine = new CashMachine([10, 5, 'a']);
        $this->assertTrue($cache_machine instanceof CashMachine);
        $this->assertEquals([10, 5], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithAllBadNotes()
    {
        $cache_machine = new CashMachine(['a', 'b', 'z']);
        $this->assertTrue($cache_machine instanceof CashMachine);
        $this->assertEquals([100, 50, 20, 10], $cache_machine->getAvailableNotes());
    }

    public function testWithdrawWithEmptyAmount()
    {
        $cache_machine = new CashMachine();
        $this->assertEquals([], $cache_machine->withdraw(null));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithdrawWithNegativeAmount()
    {
        $cache_mathine = new CashMachine();
        $cache_mathine->withdraw(-130);
    }

    public function testWithdrawCommonWay()
    {
        $cache_machine = new CashMachine();
        $this->assertEquals([20, 10], $cache_machine->withdraw(30));
        $this->assertEquals([50, 20, 10], $cache_machine->withdraw(80));
        $this->assertEquals([50, 20, 20], $cache_machine->withdraw(90));
    }

    /**
     * @expectedException Sibirtsev\Urbanara\NoteUnavailableException
     */
    public function testWithdrawWithRemainder()
    {
        $cache_machine = new CashMachine();
        $cache_machine->withdraw(125);
    }

    public function testWithdrawWithUnusualNotes()
    {
        $cache_machine = new CashMachine([2.5, 10]);
        $this->assertEquals([10, 2.5, 2.5, 2.5], $cache_machine->withdraw(17.5));
    }
}
