<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Partner;
use App\Entity\PartnerObservation;
use App\Repository\CompanyRepository;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PartnerController extends AbstractController
{
    #[Route('/partners', name: 'list_partner', methods: ['GET'])]
    public function list(PartnerRepository $partnerRepository): JsonResponse
    {
        return $this->json([
            'partners' => $partnerRepository->findBy(['status' => 'ativo']),
        ]);
    }

    #[Route('/partner/{partner_id}', name: 'list_partner_by_id', methods: ['GET'])]
    public function listById(int $partner_id, PartnerRepository $partnerRepository): JsonResponse
    {
        $partner = $partnerRepository->findById($partner_id);

        if (!$partner) {
            return $this->json([
                'error' => 'partner not found'
            ], 404);
        }
        return $this->json([
            'partners' => $partner
        ]);
    }
    #[Route('/partner/{partner_id}', name: 'update_partner', methods: ['PUT'])]
    public function update(int $partner_id, Request $request, PartnerRepository $partnerRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $partner_request = json_decode($request->getContent(), true);
        $partner = $partnerRepository->find($partner_id);
        $changes = [];

        if (!isset ($partner_request['observation']) || empty ($partner_request['observation'])) {
            return $this->json([
                'message' => 'Failed!',
                'error' => 'attribute observation is required'
            ], 400);
        }

        if (!$partner) {
            return $this->json(['message' => 'partner not found'], 404);
        }

        if (isset ($partner_request['name']) && $partner_request['name'] !== $partner->getName()) {
            $changes['name'] = [
                'old_value' => $partner->getName(),
                'new_value' => $partner_request['name']
            ];
            $partner->setName($partner_request['name']);
        }
        if (isset ($partner_request['cpf']) && $partner_request['cpf'] !== $partner->getCpf()) {
            $changes['cpf'] = [
                'old_value' => $partner->getCpf(),
                'new_value' => $partner_request['cpf']
            ];
            $partner->setCpf($partner_request['cpf']);
        }
        if (isset ($partner_request['status']) && $partner_request['status'] !== $partner->getStatus()) {
            $changes['status'] = [
                'old_value' => $partner->getstatus(),
                'new_value' => $partner_request['status']
            ];
            $partner->setStatus($partner_request['status']);
        }

        foreach ($changes as $attribute => $change) {
            $partnerObservation = new PartnerObservation();
            $partnerObservation->setpartner($partner);
            $partnerObservation->setAttribute($attribute);
            $partnerObservation->setOldValue($change['old_value']);
            $partnerObservation->setNewValue($change['new_value']);
            $partnerObservation->setObservation($partner_request['observation'] ?? '');
            $partnerObservation->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
            $entityManager->persist($partnerObservation);
        }

        $partner->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $entityManager->persist($partner);

        $entityManager->flush();

        return $this->json([
            'message' => 'partner updated successfully!',
            'partner' => $partner
        ]);
    }

    #[Route('/partner/{partner_id}', name: 'delete_partner', methods: ['Delete'])]
    public function delelte(int $partner_id, PartnerRepository $partnerRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $partner = $partnerRepository->find($partner_id);

        if (!$partner) {
            return $this->json(['message' => 'partner not found'], 404);
        }

        $partnerObservation = new PartnerObservation();
        $partnerObservation->setPartner($partner);
        $partnerObservation->setAttribute('status');
        $partnerObservation->setOldValue($partner->getStatus());
        $partnerObservation->setNewValue("inativo");
        $partnerObservation->setObservation('Empresa excluida');
        $partnerObservation->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $entityManager->persist($partnerObservation);

        $partner->setStatus('inativo');
        $partner->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $entityManager->flush();

        return $this->json([
            'message' => 'partner deleted succesfully!',
            'partner' => $partner
        ]);

    }

    #[Route('/add/partner', name: 'create_partner', methods: ['POST'])]
    public function create(Request $request, PartnerRepository $partnerRepository, CompanyRepository $companyRepository): JsonResponse
    {
        $partner_request = json_decode($request->getContent(), true);
        $error = [];

        if (!isset ($partner_request['name']) || empty ($partner_request['name'])) {
            $error['name'] = 'attribute name is required';
        }
        if (!isset ($partner_request['cpf']) || empty ($partner_request['cpf'])) {
            $error['cpf'] = 'attribute cpf is required';
        } else {
            $existing_partner = $partnerRepository->findOneBy(['cpf' => $partner_request['cpf']]);
            if ($existing_partner) {
                $error['cpf'] = 'cpf already registered';
            }
        }

        // if (!isset ($partner_request['id_company']) || empty ($partner_request['id_company'])) {
        //     $error['id_company'] = 'attribute id_company is required';
        // }

        if (!empty ($error)) {
            return $this->json([
                'message' => 'Failed!',
                'error' => $error
            ], 400);
        }

        // $company = $companyRepository->findOneBy(['id' => $partner_request['id_company']]);

        $partner = $partnerRepository->convertToPartner($request);
        // $partner->addCompany($company);


        $partnerRepository->add($partner, true);

        return $this->json([
            'message' => 'partner created succesfully!',
            'partner' => $partner
        ], 201);
    }
    #[Route('/add/partner_company', name: 'create_partner_company', methods: ['POST'])]
    public function create_relation(Request $request, PartnerRepository $partnerRepository, CompanyRepository $companyRepository): JsonResponse
    {
        $partner_request = json_decode($request->getContent(), true);
        $error = [];

        if (!isset ($partner_request['id_company']) || empty ($partner_request['id_company'])) {
            $error['id_company'] = 'attribute id_company is required';
        }
        if (!isset ($partner_request['id_partner']) || empty ($partner_request['id_partner'])) {
            $error['id_partner'] = 'attribute id_partner is required';
        }
        if (!empty ($error)) {
            return $this->json([
                'message' => 'Failed!',
                'error' => $error
            ], 400);
        }


        $company = $companyRepository->findOneBy(['id' => $partner_request['id_company']]);
        $partner = $partnerRepository->findOneBy(['id' => $partner_request['id_partner']]);

        $partner->addCompany($company);



        return $this->json([
            'message' => 'relation created succesfully!',
            'company' => $company,
            'partner' => $partner,
        ], 201);
    }
}
