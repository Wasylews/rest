<?php

declare(strict_types=1);

namespace App\V1\Http\Controller;

class TransactionController extends \App\Http\Controller\AbstractAppController {

    /**
     * @var \App\V1\Service\TransactionService
     */
    private $service;

    public function __construct(\App\V1\Service\TransactionService $service,
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
                $transactions = new \Core\Serialization\Collections\SerializableArray($this->service->getAllForUser($userId)->toArray());
                return $this->makeResponse($transactions, $request->getParameter('type'));
            } catch (\Exception $e) {
                return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                    \Core\Http\Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function post(\Core\Http\Request $request): \Core\Http\Response {
        try {
            $request = $this->serializer->deserialize($request->getBody(),
                $request->getParameter('type'),
                \App\V1\Http\Model\CreateTransactionRequest::class);
            $this->service->add($request);
        } catch (\Exception $e) {
            return $this->makeResponse($e->getMessage(), $request->getParameter('type'),
                \Core\Http\Response::HTTP_BAD_REQUEST);
        }
        return new \Core\Http\Response(\Core\Http\Response::HTTP_OK);
    }
}