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

class ContainsNode implements NodeInterface
{
    public $field = '';

    public $value = [];

    public function __construct($data = [])
    {
        $this->field = $data['field'] ?? null;
        $this->value = $data['value'] ?? [];
    }

    public function check($args = []): bool
    {
        return in_array($args[$this->field] ?? null, $this->value);
    }

    /** @codeCoverageIgnore  */
    public function children(): array
    {
        return [];
    }

    /** @codeCoverageIgnore  */
    public function condition()
    {
        return 'contains';
    }
}
