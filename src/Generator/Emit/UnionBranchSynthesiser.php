<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\Schema;
use Poagen\Generator\Generator\Enum\EnumCatalog;

use function is_string;

/**
 * Converts inline-object branches of a top-level `oneOf` / `anyOf` into
 * synthesised branch classes (e.g. `FloatingIpCreateAssignToDroplet`) that
 * {@see ModelPlanner} queues for its drain and that `implements <Interface>`.
 * Reference branches are handled via {@see ComponentCatalog::interfacesFor}
 * when the target object Model is emitted, so only inline (non-`$ref`)
 * branches reach here.
 *
 * `branchLabel()` mirrors {@see AllOfBranchBuilder::branchLabel()} and
 * `RequestUnionPlanner::branchLabel()`'s derivation, kept as its own copy
 * here for the same reason those two are already separate: each caller
 * closes over a different accumulator shape, and there is no shared home
 * for the derivation that does not cost more than the duplication.
 *
 * Broken out on its own once {@see ModelPlanner} ran out of room — linecop
 * measures PHP files, and that one had none left to give
 * (`quality-gates-at-maximum-strictness`).
 *
 * @internal
 */
final readonly class UnionBranchSynthesiser
{
    /**
     * @return list<SynthesisedModel>
     */
    public function synthesise(ComponentShape $shape): array
    {
        $parent = $shape->phpName;
        $index = 0;
        $models = [];

        foreach ($shape->unionBranches as $branch) {
            ++$index;

            if (!$branch instanceof Schema) {
                continue;
            }

            $childName = $parent . $this->branchLabel($branch, $index);
            $models[] = SynthesisedModel::forNode($childName, $branch, [$parent]);
        }

        return $models;
    }

    private function branchLabel(Schema $branch, int $index): string
    {
        $title = $branch->title;

        if (is_string($title) && $title !== '') {
            $pascal = EnumCatalog::pascalize($title);

            if ($pascal !== '') {
                return $pascal;
            }
        }

        return 'Branch' . $index;
    }
}
