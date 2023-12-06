<?php

namespace App\Interfaces\Invoices;

interface InvoiceRepositoryInterface{

    public function index();

    public function create();

    public function store($request);

    public function show($id);

    public function edit($id);

    public function update($request);

    public function destroy($request);

    public function getProducts($id);

    public function updateStatus($request);

    public function viewPaidInvoices();

    public function viewUnPaidInvoices();

    public function viewPartialPaid();
    
    public function showPrint($request , $id);
}