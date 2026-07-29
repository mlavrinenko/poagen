<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\FindPetsByStatusStatus;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;

/**
 * The contract for the `pet` endpoints.
 *
 * Type-hint this rather than the class: hand-written convenience implements the same
 * contract and delegates to the generated implementation, so a regeneration that changes
 * the surface fails to compile instead of silently breaking the seam.
 */
interface PetClientInterface
{
    public function updatePet(Pet $body): Pet;

    public function addPet(Pet $body): Pet;

    /**
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet>
     */
    public function findPetsByStatus(FindPetsByStatusStatus $status): array;

    /**
     * @param list<string> $tags
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet>
     */
    public function findPetsByTags(array $tags): array;

    public function getPetById(int $petId): Pet;

    public function updatePetWithForm(int $petId, ?string $name = null, ?string $status = null): Pet;

    public function deletePet(int $petId, ?string $apiKey = null): void;
}
