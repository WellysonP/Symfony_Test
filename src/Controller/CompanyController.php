<?php

namespace App\Controller;

use App\Entity\CompanyObservation;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Annotation\Groups;

class CompanyController extends AbstractController
{
    #[Route('/companys', name: 'company_list', methods: ['GET'])]
    public function list(CompanyRepository $companyRepository): JsonResponse
    {
        return $this->json([
            'companys' => $companyRepository->findBy(['status' => 'ativo'])
        ]);
    }
    #[Route('/company/{company_id}', name: 'company_list_by_id', methods: ['GET'])]
    public function listById(int $company_id, CompanyRepository $companyRepository): JsonResponse
    {
        $company = $companyRepository->find($company_id);

        if (!$company) {
            return $this->json([
                'error' => 'company not found'
            ], 404);
        }
        return $this->json([
            'companys' => $company
        ]);
    }
    #[Route('/company/{company_id}', name: 'update_company', methods: ['PUT'])]
    public function update(int $company_id, Request $request, CompanyRepository $companyRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $company_request = json_decode($request->getContent(), true);
        $company = $companyRepository->find($company_id);
        $changes = [];

        if (!isset ($company_request['observation']) || empty ($company_request['observation'])) {
            return $this->json([
                'message' => 'Failed!',
                'error' => 'attribute observation is required'
            ], 400);
        }

        if (!$company) {
            return $this->json(['message' => 'Company not found'], 404);
        }


        if (isset ($company_request['name']) && $company_request['name'] !== $company->getName()) {
            $changes['name'] = [
                'old_value' => $company->getName(),
                'new_value' => $company_request['name']
            ];
            $company->setName($company_request['name']);
        }

        if (isset ($company_request['sector']) && $company_request['sector'] !== $company->getSector()) {
            $changes['sector'] = [
                'old_value' => $company->getSector(),
                'new_value' => $company_request['sector']
            ];
            $company->setSector($company_request['sector']);
        }

        if (isset ($company_request['cnpj']) && $company_request['cnpj'] !== $company->getCnpj()) {
            $changes['cnpj'] = [
                'old_value' => $company->getCnpj(),
                'new_value' => $company_request['cnpj']
            ];
            $company->setCnpj($company_request['cnpj']);
        }
        if (isset ($company_request['status']) && $company_request['status'] !== $company->getStatus()) {
            $changes['status'] = [
                'old_value' => $company->getstatus(),
                'new_value' => $company_request['status']
            ];
            $company->setStatus($company_request['status']);
        }

        foreach ($changes as $attribute => $change) {
            $companyObservation = new CompanyObservation();
            $companyObservation->setCompany($company);
            $companyObservation->setAttribute($attribute);
            $companyObservation->setOldValue($change['old_value']);
            $companyObservation->setNewValue($change['new_value']);
            $companyObservation->setObservation($company_request['observation'] ?? '');
            $companyObservation->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
            $entityManager->persist($companyObservation);
        }

        $company->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $entityManager->persist($company);

        $entityManager->flush();

        return $this->json([
            'message' => 'Company updated successfully!',
            'company' => $company
        ]);
    }

    #[Route('/company/{company_id}', name: 'delete_company', methods: ['Delete'])]
    public function delete(int $company_id, CompanyRepository $companyRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $company = $companyRepository->find($company_id);

        if (!$company) {
            return $this->json(['message' => 'Company not found'], 404);
        }

        $companyObservation = new CompanyObservation();
        $companyObservation->setCompany($company);
        $companyObservation->setAttribute('status');
        $companyObservation->setOldValue($company->getStatus());
        $companyObservation->setNewValue("inativo");
        $companyObservation->setObservation('Empresa excluida');
        $companyObservation->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $entityManager->persist($companyObservation);

        $company->setStatus('inativo');
        $company->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $entityManager->flush();

        return $this->json([
            'message' => 'Company deleted succesfully!',
            'company' => $company
        ]);
    }

    #[Route('/add/company', name: 'create_company', methods: ['POST'])]
    public function create(Request $request, CompanyRepository $companyRepository): JsonResponse
    {
        $company_request = json_decode($request->getContent(), true);
        $error = [];

        if (!isset ($company_request['name']) || empty ($company_request['name'])) {
            $error['name'] = 'attribute name is required';
        }
        if (!isset ($company_request['sector']) || empty ($company_request['sector'])) {
            $error['sector'] = 'attribute sector is required';
        }
        if (!isset ($company_request['cnpj']) || empty ($company_request['cnpj'])) {
            $error['cnpj'] = 'attribute cnpj is required';
        } else {
            $existing_company = $companyRepository->findOneBy(['cnpj' => $company_request['cnpj']]);
            if ($existing_company) {
                $error['cnpj'] = 'cnpj already registered';
            }
        }

        if (!empty ($error)) {
            return $this->json([
                'message' => 'Failed!',
                'error' => $error
            ], 400);
        }

        $company = $companyRepository->convertToCompany($request);

        $companyRepository->add($company, true);

        return $this->json([
            'message' => 'Company created succesfully!',
            'company' => $company
        ], 201);
    }
}
