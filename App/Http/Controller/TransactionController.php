<?php

declare(strict_types=1);

namespace App\Http\Controller;

class TransactionController extends AbstractAppController {

    /**
     * @var \App\Service\TransactionService
     */
    private $service;

    public function __construct(\App\Service\TransactionService $service,
                                \Core\Serialization\Serializer $serializer) {
        $this->service = $service;
        parent::__construct($serializer);
    }

    public function get(\Core\Http\Request $request): \Core\Http\Response {
        if ($request->hasParameter('id')) {
            // get transaction by id
            $transactionId = intval($request->getParameter('id'));
            try {
                $transaction = $this->service->get($transactionId);
                return $this->makeResponse($transaction, $request->getParameter('type'));
            } catch (\Exception $e) {
                return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                    \Core\Http\Response::HTTP_BAD_REQUEST);
            }
        } else {
            // get all transactions for user
            $userId = intval($request->getParameter('userId'));
            try {
                $transactions = $this->service->getAllForUser($userId);
                return $this->makeResponse($transactions, $request->getParameter('type'));
            } catch (\Exception $e) {
                return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                    \Core\Http\Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $transaction = $this->serializer->deserialize($request->getBody(),
                $request->getParameter('type'),
                \App\Database\Model\TransactionModel::class);
            $this->service->add($transaction);
        } catch (\Core\Serialization\SerializationException $e) {
            return new \Core\Http\Response(\Core\Http\Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }
}