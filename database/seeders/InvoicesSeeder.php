<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoicesSeeder extends Seeder
{
    
    public function run()
    {

        // Delete existing records using DB facade
        DB::table('invoices')->delete();
        DB::table('invoice_details')->delete();

        
        // Retrieve sections and products from the database
        $sections = Section::pluck('id')->toArray();

        $products = DB::table('products')->pluck('product_name')->toArray();

        $statuses = ['مدفوعة', 'غير مدفوعة', 'مدفوعة جزئيا'];

        foreach ($statuses as $status) {
            for ($i = 0; $i < 10; $i++) {

                $invoiceDate = Carbon::now()->subDays(rand(1, 30));
                $dueDate = Carbon::now()->addDays(rand(1, 30));

                $sectionId = $sections[array_rand($sections)];
                $product = $products[array_rand($products)];

                // Ensure due date is after or equal to the invoice date
                $dueDate = $dueDate->greaterThanOrEqualTo($invoiceDate) ? $dueDate : $invoiceDate;

                $invoiceData = [
                    'invoice_number' => 'INV-' . strtoupper(substr(uniqid(), 7)),
                    'invoice_date' => $invoiceDate,
                    'due_date' => $dueDate,
                    'product' => $product,
                    'section_id' => $sectionId,
                    'amount_collection' => $status == 'مدفوعة' ? rand(100, 1000) : ($status == 'مدفوعة جزئيا' ? rand(100, 800) : null),
                    'amount_commission' => rand(10, 100),
                    'discount' => rand(0, 50),
                    'value_vat' => rand(5, 20),
                    'rate_vat' => '5%',
                    'total' => rand(500, 5000),
                    'status' => $status,
                    'value_status' => $status == 'مدفوعة' ? 1 : ($status == 'مدفوعة جزئيا' ? 2 : 0),
                    'note' => ucfirst($status) . ' invoice note ' . ($i + 1),
                    'payment_date' => $status == 'مدفوعة' || $status == 'مدفوعة جزئيا' ? Carbon::now()->subDays(rand(1, 10)) : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $invoice = Invoice::create($invoiceData);

                    $invoiceDetailsData = [

                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'product' => $invoice->product,
                        'section_id' => $invoice->section_id,
                        'status' => $invoice->status,
                        'value_status' => $invoice->value_status,
                        'payment_date' => $invoice->payment_date,
                        'note' => $invoice->note,
                        'user' => 'seeder',
                        'deleted_at' => null,
                        'created_at' => now(),
                        'updated_at' => now(),

                    ];

                    InvoiceDetail::create($invoiceDetailsData);

            }
        }
    }
}
