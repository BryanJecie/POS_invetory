<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/

class InvoiceController extends Controller
{
 	public function new_invoice()
 	{
 		$this->view->load('default','login/new.invoice',[
				'title' => 'New Invoice',
 			]);
 	}
 	public function manage_invoice()
 	{
 		$this->view->load('default','login/new.invoice',[
				'title' => 'Invoices',
 			]);
 	}
}

