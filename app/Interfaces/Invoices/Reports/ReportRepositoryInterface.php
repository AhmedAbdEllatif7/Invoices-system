<?php

namespace App\Interfaces\Invoices\Reports;

interface ReportRepositoryInterface {

    public function index();

    public function searchReports($request);

    public function searchByTypeAndDate($request);

    public function searchByType($request);

    public function searchByDateAndType($request);
    
    public function searchByInvoiceNumber($request);

    public function indexClients();

    public function searchClientReports($request);

    public function getSectionName($sectionId);

    public function filterInvoices($request);
}