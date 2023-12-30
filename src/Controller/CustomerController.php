<?php
// src/Controller/CustomerController.php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends AbstractController
{

     #[Route('/customers', name: 'get_customers', methods: ['GET'])]
    public function getCustomers(CustomerRepository $customerRepository): JsonResponse
    {
        $customers = $customerRepository->findAll();

        $data = [];
        foreach ($customers as $customer) {
            $data[] = [
                $customer->getFirstName().' '.$customer->getLastName(),
                'email' => $customer->getEmail(),
                'country' => $customer->getCountry(),
            ];
        }

        return $this->json($data);
    }

  

     #[Route('/customers/{customerId}', name: 'get_customer', methods: ['GET'])]
    public function getCustomer($customerId, CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $customerRepository->find($customerId);

        if (!$customer) {
            throw $this->createNotFoundException('Customer not found');
        }

        $data = [
            'fullName' => $customer->getFirstName().' '.$customer->getLastName(),
            'email' => $customer->getEmail(),
            // 'username' => $customer->getUsername(),
            // 'gender' => $customer->getGender(),
            'country' => $customer->getCountry(),
            // 'city' => $customer->getCity(),
            // 'phone' => $customer->getPhone(),
        ];

        return $this->json($data);
    }
  

     #[Route('/customers', name: 'create_customer', methods: ['POST'])]
    public function createCustomer(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $customer = new Customer();
        $customer->setFirstName($data['firstName']);
        $customer->setLastName($data['lastName']);
        $customer->setEmail($data['email']);
        $customer->setCountry($data['country']);

        $entityManager->persist($customer);
        $entityManager->flush();

        return $this->json(['status' => 'Customer created'], Response::HTTP_CREATED);
    }
    

 #[Route('/customers/{customerId}', name: 'edit_customer', methods: ['PUT'])]
public function editCustomer($customerId, Request $request, EntityManagerInterface $entityManager): JsonResponse
{
    $customer = $entityManager->getRepository(Customer::class)->find($customerId);

    if (!$customer) {
        throw $this->createNotFoundException('No customer found for id '.$customerId);
    }

    $data = json_decode($request->getContent(), true);

    if (isset($data['firstName'])) {
        $customer->setFirstName($data['firstName']);
    }
    if (isset($data['lastName'])) {
        $customer->setLastName($data['lastName']);
    }
    if (isset($data['email'])) {
        $customer->setEmail($data['email']);
    }
    if (isset($data['country'])) {
        $customer->setCountry($data['country']);
    }

    $entityManager->flush();

    return $this->json(['status' => 'Customer updated'], Response::HTTP_OK);
}


     #[Route('/customers/{customerId}', name: 'delete_customer', methods: ['DELETE'])]
    public function deleteCustomer($customerId, CustomerRepository $customerRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $customer = $customerRepository->find($customerId);

        if (!$customer) {
            throw $this->createNotFoundException('Customer not found');
        }

        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->json(['status' => 'Customer deleted'], Response::HTTP_OK);
    }
}

