<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\FindPetsByStatusStatus;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;

final readonly class PetClient implements PetClientInterface
{
    public function __construct(
        private TransportInterface $transport,
    ) {
    }

    public function updatePet(Pet $body): Pet
    {
        return $this->transport->send(
            Endpoint::put('/pet')->json($body),
            ResponseType::object(Pet::class),
        );
    }

    public function addPet(Pet $body): Pet
    {
        return $this->transport->send(
            Endpoint::post('/pet')->json($body),
            ResponseType::object(Pet::class),
        );
    }

    /**
     * @return list<Pet>
     */
    public function findPetsByStatus(FindPetsByStatusStatus $status): array
    {
        return $this->transport->send(
            Endpoint::get('/pet/findByStatus')->query('status', $status),
            ResponseType::listOf(Pet::class),
        );
    }

    /**
     * @param list<string> $tags
     * @return list<Pet>
     */
    public function findPetsByTags(array $tags): array
    {
        return $this->transport->send(
            Endpoint::get('/pet/findByTags')->query('tags', $tags),
            ResponseType::listOf(Pet::class),
        );
    }

    public function getPetById(int $petId): Pet
    {
        return $this->transport->send(
            Endpoint::get('/pet/{petId}')->path('petId', $petId),
            ResponseType::object(Pet::class),
        );
    }

    public function updatePetWithForm(int $petId, ?string $name = null, ?string $status = null): Pet
    {
        return $this->transport->send(
            Endpoint::post('/pet/{petId}')
                ->path('petId', $petId)
                ->query('name', $name)
                ->query('status', $status),
            ResponseType::object(Pet::class),
        );
    }

    public function deletePet(int $petId, ?string $apiKey = null): void
    {
        $this->transport->send(
            Endpoint::delete('/pet/{petId}')->path('petId', $petId)->header('api_key', $apiKey),
            ResponseType::nothing(),
        );
    }
}
