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

class Node
{
    public static function pack(NodeInterface $node)
    {
        $encode = [];
        if ($node instanceof NodeGroupInterface) {
            foreach ($node->children() as $child) {
                /* @var NodeInterface $child */
                $encode[$child->condition()] += static::pack($child);
            }
        } else {
            $encode = [
                $node->field => $node->value,
            ];
        }

        return [
            $node->condition() => $encode,
        ];
    }

    public static function unpack($syntaxTreeString): NodeInterface
    {
        return json_decode($syntaxTreeString);
    }
}
