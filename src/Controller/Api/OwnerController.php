<?php

namespace App\Controller\Api;

use App\Entity\Owner;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OwnerController extends AbstractApiController
{
    /**
     * @param Owner $owner
     *
     * @return JsonResponse
     */
    public function fetch(Owner $owner): JsonResponse
    {
        return $this->json(['owner' => $owner]);
    }

    /**
     * @param Request $request
     * @param Owner   $owner
     *
     * @return JsonResponse
     */
    public function update(
        Request $request,
        Owner $owner
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['name']) || !isset($data['icon'])) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $name = $data['name'];
        $icon = $data['icon'];
        $manager = $this->getDoctrine()->getManager();
        $ownerRepo = $manager->getRepository(Owner::class);
        $error = [];
        if (!$ownerRepo->checkUniqueFieldConflict('name', $name, $owner->getId())) {
            $error['name'] = sprintf('Owner with name "%s" exists already.', $name);
        }
        if (!empty($error)) {
            return $this->responseBadRequestWithErrorDetail($error);
        }

        $owner
            ->setName($name)
            ->setIcon($icon)
            ->setModifiedAt(new \DateTimeImmutable());

        $manager->flush();

        return $this->responseSuccessWithNoContent();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['name']) || !isset($data['icon'])) {
            return $this->responseBadRequestWithMessage('Invalid parameters.');
        }

        $name = $data['name'];
        $icon = $data['icon'];
        $manager = $this->getDoctrine()->getManager();
        $ownerRepo = $manager->getRepository(Owner::class);
        $error = [];
        if (!$ownerRepo->checkUniqueFieldConflict('name', $name)) {
            $error['name'] = sprintf('Owner with name "%s" exists already.', $name);
        }
        if (!empty($error)) {
            return $this->responseBadRequestWithErrorDetail($error);
        }

        $owner = new Owner();
        $owner
            ->setName($name)
            ->setIcon($icon)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($owner);
        $manager->flush();

        return $this->json(['owner' => $owner]);
    }

    /**
     * @param Owner $owner
     *
     * @return JsonResponse
     */
    public function delete(Owner $owner): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($owner);
        try {
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException $exception) {
            return $this->responseBadRequestWithMessage(
                'Delete failed! This owner is still being used by other entity.'
            );
        }

        return $this->responseSuccessWithNoContent();
    }
}
