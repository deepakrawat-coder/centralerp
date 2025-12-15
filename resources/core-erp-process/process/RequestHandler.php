<?php

require_once __DIR__ . '/services/StudentService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/WalletService.php';
require_once __DIR__ . '/services/LedgerService.php';
require_once __DIR__ . '/services/DashboardsService.php';
class RequestHandler
{
    private $services = [];
    private $logger;

    public function __construct($db)
    {
        $this->logger = new Logger();

        // Register all services
        $this->services = [
            "students" => new StudentService($db, $this->logger),
            "users"    => new UserService($db, $this->logger),
            "wallet"   => new WalletService($db, $this->logger),
            "ledger"   => new LedgerService($db, $this->logger),
            "dashboard" => new DashboardsService($db,$this->logger),
        ];
    }

    /**
     * Handle API request
     */
    public function handle($method, $uniId = null, $filters = [])
    {
        $this->logger->info("REQUEST RECEIVED", [
            "method" => $method,
            "uni_id" => $uniId,
            "filters" => $filters
        ]);

        // Check valid API method
        if (!isset($this->services[$method])) {
            $this->logger->error("INVALID_METHOD", ["method" => $method]);
            throw new Exception("Invalid API method: $method");
        }

        $service = $this->services[$method];

        // ✔ Directly return service list data
        $result = $service->list($uniId, $filters);

        $this->logger->info("REQUEST_SUCCESS", [
            "method" => $method,
            "records" => is_array($result) ? count($result) : 0
        ]);

        return $result;
    }
}
