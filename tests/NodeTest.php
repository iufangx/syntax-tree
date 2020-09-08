<?php

declare(strict_types=1);

/**
 * Fangx's Packages
 *
 * @link     https://nfangxu.com
 * @document https://pkg.nfangxu.com
 * @contact  nfangxu@gmail.com
 * @author   nfangxu
 * @license  https://pkg.nfangxu.com/license
 */

namespace Fangx\Tests;

use Fangx\SyntaxTree\AndGroup;
use Fangx\SyntaxTree\ContainsNode;
use Fangx\SyntaxTree\EqualsNode;
use Fangx\SyntaxTree\Node;
use Fangx\SyntaxTree\OrGroup;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class NodeTest extends TestCase
{
    public function testCheckAndGroup()
    {
        $group = new AndGroup();

        $group
            ->append(new EqualsNode(['field' => 'condition_1', 'value' => '1']))
            ->append(new EqualsNode(['field' => 'condition_2', 'value' => '2']))
            ->append(new ContainsNode(['field' => 'condition_3', 'value' => ['3.0', '3.1']]));

        $this->assertTrue($group->check(['condition_1' => '1', 'condition_2' => '2', 'condition_3' => '3.1']));
        $this->assertTrue($group->check(['condition_1' => '1', 'condition_2' => '2', 'condition_3' => '3.0']));
        $this->assertFalse($group->check(['condition_1' => '1']));
        $this->assertFalse($group->check(['condition_2' => '2']));
        $this->assertFalse($group->check(['condition_3' => '3.0']));
    }

    public function testCheckOrGroup()
    {
        $group = new OrGroup();

        $group
            ->append(new EqualsNode(['field' => 'condition_1', 'value' => '1']))
            ->append(new EqualsNode(['field' => 'condition_2', 'value' => '2']))
            ->append(new ContainsNode(['field' => 'condition_3', 'value' => ['3.0', '3.1']]));

        $this->assertTrue($group->check(['condition_1' => '1', 'condition_2' => '2', 'condition_3' => '3.1']));
        $this->assertTrue($group->check(['condition_1' => '1', 'condition_2' => '4', 'condition_3' => '3.1']));
        $this->assertTrue($group->check(['condition_1' => '3', 'condition_2' => '2', 'condition_3' => '3.0']));
        $this->assertTrue($group->check(['condition_1' => '1', 'condition_2' => '2', 'condition_3' => '3.3']));
        $this->assertFalse($group->check(['condition_1' => '2', 'condition_2' => '3', 'condition_3' => '3.3']));
        $this->assertTrue($group->check(['condition_1' => '1']));
        $this->assertTrue($group->check(['condition_2' => '2']));
        $this->assertTrue($group->check(['condition_3' => '3.0']));
    }

    public function testNodePack()
    {
        $this->assertEquals('{"equals":{"condition_1":"1"}}', json_encode(Node::pack(new EqualsNode(['field' => 'condition_1', 'value' => '1']))));
        $this->assertEquals('{"contains":{"condition_3":["3.0","3.1"]}}', json_encode(Node::pack(new ContainsNode(['field' => 'condition_3', 'value' => ['3.0', '3.1']]))));
    }
}
