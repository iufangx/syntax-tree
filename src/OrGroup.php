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

namespace Fangx\SyntaxTree;

class OrGroup implements NodeGroupInterface
{
    protected $children = [];

    public function check($args = []): bool
    {
        foreach ($this->children() as $child) {
            /** @var NodeInterface $child */
            if ($child->check($args)) {
                return true;
            }
        }

        return false;
    }

    public function children(): array
    {
        return $this->children;
    }

    public function append(NodeInterface $node): NodeGroupInterface
    {
        $this->children[] = $node;
        return $this;
    }

    /** @codeCoverageIgnore  */
    public function condition()
    {
        return 'or';
    }
}
