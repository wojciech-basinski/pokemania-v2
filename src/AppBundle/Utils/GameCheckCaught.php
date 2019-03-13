<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GameCheckCaught
{
    /**
     * @var PokemonHelper
     */
    private $pokemonHelper;

    /**
     * @var User|null
     */
    private $user = null;

    /**
     * @var array
     */
    private $userCollection = null;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var Collection
     */
    private $collectionService;

    public function __construct(
        PokemonHelper $pokemonHelper,
        TokenStorageInterface $tokenStorage,
        Collection $collectionService) {
        $this->pokemonHelper = $pokemonHelper;
        $this->tokenStorage = $tokenStorage;
        $this->collectionService = $collectionService;
    }

    public function check(string $place): array
    {
        $this->prepareUser();
        $this->prepareCollection();
        return $this->{'catched' . $place}();
    }

    public function checkIfAllCaught(string $place, bool $withLegends = false): bool
    {
        $collection = $this->check($place);
        foreach ($collection as $pokemon) {
            if (in_array($pokemon['id'], [144, 145, 146, 150, 151])) {
                if ($withLegends) {
                    if (!$pokemon['caught']) {
                        return false;
                    }
                }
            } else {
                if (!$pokemon['caught']) {
                    return false;
                }
            }
        }
        return true;
    }

    private function checkCatched(array $pokemons): array
    {
        $table = [];
        $count = count($pokemons);
        for ($i = 0; $i < $count; $i++) {
            $regionName = $this->getRegionNameFromPokemonId($pokemons[$i]);
            $id = $this->getIdInCollection($pokemons[$i]);
            $table[$i] = [
                'id' => $pokemons[$i],
                'name' => $this->pokemonHelper->getInfo($pokemons[$i])['name'],
                'caught' => $this->userCollection[$regionName][$id - 1]['caught'],
                'met' => $this->userCollection[$regionName][$id - 1]['meet'],
            ];
        }
        return $table;
    }

    private function catchedMrocznyLas(): array
    {
        $pokemons = [
            41, 42, 163, 164, 167, 168, 169, 197, 198, 200, 214, 215, 228, 229
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedJezioro(): array
    {
        $pokemons = [
            79, 80, 116, 117, 158, 159, 160, 170, 171, 183, 184, 199, 223, 224, 226, 230
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedJohto5(): array
    {
        $pokemons = [
            35, 36, 39, 40, 113, 173, 174, 175, 176, 177, 178, 201, 202, 203, 242
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedWulkan(): array
    {
        $pokemons = [
            95, 123, 126, 155, 156, 157, 185, 190, 196, 207, 208, 212, 218, 219, 227, 228, 229, 240
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedMokradla(): array
    {
        $pokemons = [
            60, 61, 183, 184, 193, 194, 195, 206, 211, 214, 222, 234
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedLodowiec(): array
    {
        $pokemons = [
            124, 137, 215, 216, 217, 220, 221, 225, 231, 232, 233, 234, 238, 246, 247, 248
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedLaka(): array
    {
        $pokemons = [
            43, 44, 152, 153, 154, 161, 162, 165, 166, 172, 177,
            178, 179, 180, 181, 182, 187, 188, 189, 191, 192, 204, 205, 209, 210, 241
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedPolana(): array
    {
        $pokemons = [
            1, 2, 3, 10, 11, 12, 13, 14, 15, 16, 17, 18, 23, 24, 25, 26,
            37, 38, 43, 44, 45, 69, 70, 71, 102, 103, 108, 114, 133
        ];
        if ($this->user->getTrainerLevel() >= 100) {
            $pokemons[] = 151;
        }
        return $this->checkCatched($pokemons);
    }

    private function catchedWyspa(): array
    {
        $pokemons = [
            19, 20, 23, 24, 29, 30, 31, 32, 33, 34, 46, 47, 48, 49, 52,
            53, 58, 59, 79, 80, 96, 97, 98, 99, 100, 101, 108, 124
        ];
        if ($this->user->getTrainerLevel() >= 100) {
            $pokemons[] = 150;
        }
        return $this->checkCatched($pokemons);
    }

    private function catchedGrota(): array
    {
        $pokemons = [
            23, 24, 27, 28, 35, 36, 39, 40, 41, 42, 50, 51, 88, 89, 92, 93, 94, 95, 109, 110
        ];
        if ($this->user->getTrainerLevel() >= 100) {
            $pokemons[] = 146;
        }
        return $this->checkCatched($pokemons);
    }

    private function catchedDomStrachow(): array
    {
        $pokemons = [
            19, 20, 41, 42, 63, 64, 65, 88, 89, 92, 93, 94, 96, 97, 104, 105, 106, 107, 122, 124, 137
        ];
        return $this->checkCatched($pokemons);
    }

    private function catchedGory(): array
    {
        $pokemons = [
            4, 5, 6, 21, 22, 56, 57, 66, 67, 68, 74, 75, 76, 77, 78, 81, 82, 95, 104, 105, 111, 112
        ];
        if ($this->user->getTrainerLevel() >= 100) {
            $pokemons[] = 145;
        }
        return $this->checkCatched($pokemons);
    }

    private function catchedWodospad(): array
    {
        $pokemons = [
            7, 8, 9, 54, 55, 60, 61, 62, 72, 73, 79, 80, 86, 87, 90, 91,
            98, 99, 116, 117, 118, 119, 120, 121, 129, 130, 131
        ];
        if ($this->user->getTrainerLevel() >= 100) {
            $pokemons[] = 144;
        }
        return $this->checkCatched($pokemons);
    }

    private function catchedSafari(): array
    {
        $pokemons = [
            21, 22, 46, 47, 48, 49, 54, 55, 83, 84, 85, 102, 103, 108, 111,
            112, 113, 114, 115, 123, 124, 125, 126, 127, 128
        ];
        return $this->checkCatched($pokemons);
    }

    private function getRegionNameFromPokemonId(int $id): string
    {
        if ($id <= 151) {
            return 'kanto';
        }
        if ($id <= 251) {
            return 'johto';
        }
    }

    private function getIdInCollection(int $id): int
    {
        if ($id <= 151) {
            return $id;
        }
        if ($id <= 251) {
            return $id - 151;
        }
    }

    private function prepareUser(): void
    {
        if ($this->user === null) {
            $this->user = $this->tokenStorage->getToken()->getUser();
        }
    }

    private function prepareCollection(): void
    {
        if ($this->userCollection === null) {
            $this->userCollection = $this->collectionService->getUserCollection($this->user->getId());
        }
    }
}