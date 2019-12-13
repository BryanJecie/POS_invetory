<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
 */
class ProductController extends Controller
{
	public function __construct()
	{

		switch (App::$auth->data()->user_role) {
			case 'cashier':
				Redirect::to('page/pos');
				break;
		}

		if (!App::$auth->isLoggedIn()) {
			Redirect::to('index/userAuth');
		}
		Parent::__construct();
	}

	public function manage_product()
	{
		$this->loadModel('product');

		if (Input::exist()) {
			$password = Input::get('password');
			$prodId = Input::get('prodId');

			$adminCred = Query::getSql()->query("
								SELECT
								user_role.user_role,
								users.`password`,
								users.user_salt
								FROM
								users
								INNER JOIN user_role ON users.role_id = user_role.role_id
								WHERE
								user_role.user_role = 'admin'
							")->get();

			$role = $adminCred->user_role;
			$salt = $adminCred->user_salt;
			$aPW = $adminCred->password;

			if ($aPW === Hash::make($password, $salt)) {

				Query::delete('product', ['product_id', '=', $prodId]);
				if (Query::count()) {
					Session::setFlash('<div class="alert alert-success fade in m-b-15">
								           	 <i class="fa fa-check"></i>
								          	 	Product has successfully Deleted.
								             <span class="close" data-dismiss="alert">×</span>
								           </div>');
				}

			} else {
				Session::setFlash('<div class="alert alert-danger fade in m-b-15">
							           	 <i class="fa fa-times"></i>
							          	 	Admin password is incorrect or Only Admin Can Delete Product.
							             <span class="close" data-dismiss="alert">×</span>
							           </div>');
			}
		}

		$stockin = $this->model->getProductStockin();

		$this->view->load('default', 'product/manage_product', [
			'title' => 'Manage Product',
			'stockin' => $stockin
		]);
	}
	public function edit_damage_product($damageId = null)
	{
		if (is_null($damageId)) {
			Redirect::to('product/damage_product');
		}
		$this->loadModel('product');


		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$barcode = Input::get('barcode');
				$inputQty = Input::get('quantity');

				Query::select('product_damage', ['damage_id', '=', $damageId]);

				if (Query::count()) {

					$damageQty = Query::first()->damage_quantity;

					if (!is_null(Query::first()->damage_decrease)) {

						$stocks = Query::getSql()->query("
     							SELECT barcode.barcode_id, stockin_summary.stockin_sum_selling_quantity
     							FROM barcode
     							INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
     							WHERE barcode.barcode = '{$barcode}'
     							GROUP BY barcode.barcode_id
     					")->get();

						$barcodeId = $stocks->barcode_id;

						$stockinSum = $stocks->stockin_sum_selling_quantity + $damageQty;
						$totalQty = ($stockinSum - $inputQty);

						Query::update('Stockin_summary', 'barcode_id', $barcodeId, [
							'stockin_sum_selling_quantity' => $totalQty
						]);
					}

					Query::update('product_damage', 'damage_id', $damageId, [
						'damage_quantity' => $inputQty,
						'damage_quantity_type' => Input::get('quantity-type'),
						'damage_note' => Input::get('note')
					]);

					if (Query::count()) {
						Session::setFlash('Damage Product Successfully Update.');
					}
				}
			}
		}




		$damges = $this->model->get_damage_product($damageId);

		$this->view->load('default', 'product/edit.damage', [
			'title' => 'Damage Product',
			'product' => $damges,
			'damageId' => $damageId
		]);
	}
	public function add_damage_product()
	{
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				/* Process Validation Here */
				$validate = new Validate;

				$valid = $validate->check($_POST, [
					'barcode' => [
						'unique' => 'barcode'
					]
				]);

				$barcode = Input::get('barcode');

				if ($valid->passed()) {
					Session::setFlash('Barcode <b>' . $barcode . '</b> does not exist');
				} else {

				    /* Process Damage Insert Here */
					$stocks = Query::getSql()->query("
								SELECT
								barcode.barcode_id,
								stockin_summary.stockin_sum_selling_quantity
								FROM barcode
								INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
								WHERE
								barcode.barcode = '{$barcode}'
								GROUP BY
								barcode.barcode_id
						")->get();

					$stockinSum = $stocks->stockin_sum_selling_quantity;
					$barcodeId = $stocks->barcode_id;

					$totalStocks = ($stockinSum - Input::get('quantity'));


					$decrease = null;
					if (Input::get('decrease')) {
						Query::update('Stockin_summary', 'barcode_id', $barcodeId, [
							'stockin_sum_selling_quantity' => $totalStocks
						]);

						$decrease = Input::get('decrease');
					}


					Query::insert('product_damage', [
						'barcode_id' => $barcodeId,
						'damage_date' => date('Y-m-d'),
						'damage_quantity' => Input::get('quantity'),
						'damage_quantity_type' => Input::get('quanity-type'),
						'damage_note' => Input::get('note'),
						'damage_decrease' => $decrease,
					]);

					if (Query::count()) {
						Session::setFlash('Damage Product Successfully Added.');
					}
				}

			}
		}
		$this->view->load('default', 'product/add_damage', ['title' => 'Damage Product']);
	}
	public function damage_product()
	{
		$this->loadModel('product');

		$damage = $this->model->getDamageProduct();

		$this->view->load('default', 'product/damage_product', [
			'title' => ' Damage Product',
			'damages' => $damage
		]);
	}
	public function add_product_category()
	{
		$this->loadModel('product');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$validate = new Validate;

				$valid = $validate->check($_POST, [
					'type_name' => [
						'unique' => 'product_type'
					]
				]);

				if ($valid->passed()) {
					if (Input::get('insert') == 'insert') {
						Query::insert('product_type', [
							'type_name' => Input::get('type_name')
						]);
						if (Query::count()) {
							Session::setFlash(
								'<div class="alert alert-success alert-dismissable fade-msg">
			                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                        <b><i class="fa fa-check"></i></b>
			                        Category ' . ucwords(Input::get('cat-name')) . ' Save
								</div>'
							);
						}
					}
				} else {

					$er = '';
					foreach ($valid->errors() as $error)
						$er .= ' ' . $error . '<br>';
					Session::setFlash(
						'<div class="alert alert-danger alert-dismissable fade-msg">
			                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                        <b><i class="fa fa-times"></i></b>
			                        ' . $er . '
								</div>'
					);
				}
			} elseif (Input::get('update') == 'update') {
				Query::update('product_type', 'type_id', Input::get('type_id'), [
					'type_name' => Input::get('type_name')
				]);
				if (Query::count()) {
					Session::setFlash(
						'<div class="alert alert-success alert-dismissable fade-msg">
	                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	                        <b><i class="fa fa-check"></i></b>
	                        Category ' . ucwords(Input::get('type_name')) . ' Update
						</div>'
					);
				}
			}
		}

		$type = $this->model->get_all_product_type();

		$this->view->load('default', 'product/add_category', [
			'title' => 'Product Category',
			'type' => $type
		]);
	}
	public function add_sub_category()
	{


		$this->loadModel('product');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$validate = new Validate;

				$valid = $validate->check($_POST, [
					'brand_name' => [
						'unique' => 'product_brand'
					]
				]);

				if ($valid->passed()) {
					if (Input::get('insert') == 'insert') {
						Query::insert('product_brand', [
							'brand_name' => Input::get('brand_name'),
							'type_id' => Input::get('cat-id')
						]);
						if (Query::count()) {
							Session::setFlash(
								'<div class="alert alert-success alert-dismissable fade-msg">
			                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                        <b><i class="fa fa-check"></i></b>
			                        Brand ' . ucwords(Input::get('brand_name')) . ' Save
								</div>'
							);
						}
					}
				} else {

					$er = '';
					foreach ($valid->errors() as $error)
						$er .= ' ' . $error . '<br>';
					Session::setFlash(
						'<div class="alert alert-danger alert-dismissable fade-msg">
			                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                        <b><i class="fa fa-times"></i></b>
			                        ' . $er . '
								</div>'
					);
				}
			} elseif (Input::get('update') == 'update') {

				Query::update('product_brand', 'brand_id', Input::get('brand-id'), [
					'brand_name' => Input::get('brand_name'),
					'type_id' => Input::get('cate-name')
				]);

				if (Query::count()) {
					Session::setFlash(
						'<div class="alert alert-success alert-dismissable fade-msg">
	                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	                        <b><i class="fa fa-check"></i></b>
	                        Brand ' . ucwords(Input::get('brand_name') . ' & ' . Input::get('cate-name')) . ' Update
						</div>'
					);
				}
			}
		}



		$type = $this->model->get_all_product_type();

		$brand = $this->model->get_all_sub_product();

		$this->view->load('default', 'product/add_sub_category', [
			'title' => 'Product Sub Category',
			'brand' => $brand,
			'type' => $type
		]);
	}
	public function add_product()
	{
		$this->loadModel('product');

		$type = $this->model->get_all_product_type();
		$brand = $this->model->get_all_sub_product();
		$max_id = $this->model->get_max_id();




		$charAt = [',', '.'];

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$id = 1;
				if (!is_null($max_id)) {
					$id = $max_id[0]->productId;
				}
				$prodId = 0;
				$productId = 0;
				$barcodeId = 0;
				$stkStatus = (Input::get('p-quantity') < 2) ? 'in stock' : 'in stocks';
				$totalQtySum = 0;
				$pTypeQty = 0;
				$this->model->post('product', [
					'product_name' => Input::get('prodName'),
					'product_subname' => Input::get('prodSubName'),
					'product_desc' => Input::get('p-desc'),
					'product_insert_date' => date('Y-m-d'),
					'brand_id' => Input::get('p-brand')
				]);

				if ($this->model->count()) {
					$productId = $this->model->lastInsertId();
				}

				$validate = new Validate;

				$valid = $validate->check($_POST, [
					'barcode' => [
						'unique' => 'barcode'
					]
				]);

				if ($valid->passed()) {

					$this->model->post('barcode', [
						'barcode' => Input::get('barcode'),
						'product_id' => $productId
					]);

					if ($this->model->count()) {
						$barcodeId = $this->model->lastInsertId();

						if (isset($_POST['pTypeQty'])) {
							$totalQtySum = Input::get('p-quantity') * Input::get('pTypeQty');
							$pTypeQty = Input::get('pTypeQty');
						} else {
							$totalQtySum = Input::get('p-quantity');
							$pTypeQty = null;
						}

						$this->model->post('stockin_summary', [
							'stockin_sum_quantity' => Input::get('p-quantity'),
							'stockin_sum_selling_quantity' => $totalQtySum,
							'stockin_sum_buying_price' => Input::get('p-buying-price'),
							'stockin_sum_selling_price' => Input::get('p-selling-price'),
							'stockin_sum_status' => 'In Stocks',
							'stockin_sum_quantity_per' => $pTypeQty,
							'stockin_sum_quantity_type' => Input::get('p-quan-type'),
							'stockin_sum_date' => date('Y-m-d'),
							'stockin_sum_selling_type' => Input::get('selling-type'),
							'barcode_id' => $barcodeId
						]);
					}
				} else {

					$barcode = $this->model->get('barcode', ['barcode', '=', Input::get('barcode')]);
					$barcodeId = $barcode[0]->barcode_id;

					$curQuan = $this->model->get('stockin_summary', ['barcode_id', '=', $barcodeId]);

					if (isset($_POST['pTypeQty'])) {
						$totalQtySum = Input::get('p-quantity') * Input::get('pTypeQty');
						$pTypeQty = Input::get('pTypeQty');

					} else {
						$totalQtySum = Input::get('p-quantity');
						$pTypeQty = null;

					}

					$totalQ = ($curQuan[0]->stockin_sum_selling_quantity + $totalQtySum);
					$totalP = ($curQuan[0]->stockin_sum_quantity_per + $pTypeQty);

					$this->model->update('stockin_summary', 'barcode_id', $barcodeId, [
						'stockin_sum_selling_quantity' => $totalQ,
						'stockin_sum_quantity_per' => $totalP,
						'stockin_sum_buying_price' => Input::get('p-buying-price'),
						'stockin_sum_selling_price' => Input::get('p-selling-price'),
						'stockin_sum_status' => 'In Stocks',
						'stockin_sum_quantity_type' => Input::get('p-quan-type')
					]);
				}

				$stockNo = getNo('STN', $id, 5);

				$this->model->post('product_stockin', [
					'stockin_no' => $stockNo,
					'stockin_selling_quantity' => $totalQtySum,
					'stockin_quantity' => Input::get('p-quantity'),
					'stockin_quantity_per' => $pTypeQty,
					'stockin_quantity_type' => Input::get('p-quan-type'),
					'stockin_status' => $stkStatus,
					'stockin_date' => date('Y-m-d'),
					'stockin_buying_price' => Input::get('p-buying-price'),
					'stockin_selling_price' => Input::get('p-selling-price'),
					'stockin_selling_type' => Input::get('selling-type'),
					'barcode_id' => $barcodeId
				]);

				if ($this->model->count()) {
					Session::setFlash('Stockin Product Successfully Save !');
				}

				if (Input::get('image-file')) {

					$folder = PUBLIC_PATH . 'images/products/' . $productId;

					if (!file_exists($folder)) {
						mkdir($folder, 0777, true);
					} else {
						$folder = PUBLIC_PATH . 'images/products/' . $productId;
					}

					App::$image->upload_image($folder, Input::get('image-file'), true);
				}
			}
		}





		$this->view->load('default', 'product/add_product', [
			'title' => 'Products',
			'brand' => $brand,
			'type' => $type,
			'max_id' => $max_id
		]);
	}
	public function edit_product()
	{
		$this->loadModel('product');
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$tSelQty = 0;
				$tQty = 0;
				$tSckIn = 0;

				if (!is_null(Input::get('quantity-type-per')) and Input::get('quantity-type-per') !== "") {

					$tSelQty = (Input::get('quantity-type-per') * Input::get('product-quantity'));

					$this->model->get('product_stockin', ['stockin_id', '=', Input::get('stockin_id')]);



					if ($this->model->count()) {

						$pStckIn = $this->model->first()->stockin_selling_quantity;

						if (!is_null($this->model->first()->stockin_quantity_per)) {

							$this->model->get('stockin_summary', ['barcode_id', '=', Input::get('barcode_id')]);

							if ($this->model->count()) {
								$tSckIn = ($this->model->first()->stockin_sum_selling_quantity - $pStckIn);
							}
							$tQty = $tSelQty + $tSckIn;


							$this->model->update('stockin_summary', 'barcode_id', Input::get('barcode_id'), [
								'stockin_sum_quantity' => $tQty,
								'stockin_sum_selling_quantity' => $tQty,
								'stockin_sum_buying_price' => Input::get('buying-price'),
								'stockin_sum_selling_price' => Input::get('selling-price'),
								'stockin_sum_selling_type' => Input::get('selling-qty-type'),
								'stockin_sum_quantity_per' => Input::get('quantity-type-per'),
								'stockin_sum_quantity_type' => Input::get('product-quantity-type')
							]);

							$this->model->update('product_stockin', 'stockin_id', Input::get('stockin_id'), [
								'stockin_quantity' => Input::get('product-quantity'),
								'stockin_selling_quantity' => $tQty,
								'stockin_quantity_type' => Input::get('product-quantity-type'),
								'stockin_buying_price' => Input::get('buying-price'),
								'stockin_selling_price' => Input::get('selling-price'),
								'stockin_selling_type' => Input::get('selling-qty-type'),
								'stockin_quantity_per' => Input::get('quantity-type-per'),
							]);
						}

					}
				} else {

					$this->model->get('product_stockin', ['stockin_id', '=', Input::get('stockin_id')]);

					if ($this->model->count()) {
						$pStckIn = $this->model->first()->stockin_selling_quantity;

						$this->model->get('stockin_summary', ['barcode_id', '=', Input::get('barcode_id')]);

						if ($this->model->count()) {
							$tSckIn = ($this->model->first()->stockin_sum_selling_quantity - $pStckIn);
						}
						$tQty = Input::get('product-quantity') + $tSckIn;

						$this->model->update('stockin_summary', 'barcode_id', Input::get('barcode_id'), [
							'stockin_sum_quantity' => $tQty,
							'stockin_sum_selling_quantity' => $tQty,
							'stockin_sum_buying_price' => Input::get('buying-price'),
							'stockin_sum_selling_price' => Input::get('selling-price'),
							'stockin_sum_selling_type' => Input::get('selling-qty-type'),
							'stockin_sum_quantity_type' => Input::get('product-quantity-type')
						]);

						$this->model->update('product_stockin', 'stockin_id', Input::get('stockin_id'), [
							'stockin_quantity' => Input::get('product-quantity'),
							'stockin_selling_quantity' => $tQty,
							'stockin_quantity_type' => Input::get('product-quantity-type'),
							'stockin_buying_price' => Input::get('buying-price'),
							'stockin_selling_price' => Input::get('selling-price'),
							'stockin_selling_type' => Input::get('selling-qty-type'),
						]);

					}
				}

				$this->model->update('barcode', 'barcode_id', Input::get('barcode_id'), [
					'barcode' => Input::get('barcode'),
				]);
				$this->model->update('product', 'product_id', Input::get('product_id'), [
					'product_name' => Input::get('product-name'),
					'product_subname' => Input::get('product-subname'),
					'product_desc' => Input::get('desc'),
					'brand_id' => Input::get('brand'),
				]);

				if (Input::get('image-file')) {

					$folder = PUBLIC_PATH . 'images/products/' . Input::get('product_id');

					if (!file_exists($folder)) {
						mkdir($folder, 0777, true);
					} else {
						$folder = PUBLIC_PATH . 'images/products/' . Input::get('product_id');
					}
					App::$image->upload_image($folder, Input::get('image-file'), true);
				}

				Session::setFlash('Product Information Successfully Update');
			}
		}


		$prodId = $this->params[1];
		$product = $this->model->get_product_info($prodId);
		$productInfo = array();

		if (!is_null($product)) {
			$productInfo['info'] = $product[0];
			Query::select('product_brand', ['brand_id', '=', $product[0]->brand_id]);
			if (Query::count()) {
				$productInfo['brand'] = Query::first();
				Query::select('product_type', ['type_id', '=', Query::first()->type_id]);
				if (Query::count()) {
					$productInfo['type'] = Query::first();
				}
			}
		}

		if (!isset($this->params[1])) {
			Redirect::to('product/manage_product');
		}
		$this->view->load('default', 'product/edit_product', [
			'title' => 'Product',
			'product' => $productInfo,
		]);
		# code...
	}
	public function purchase_history()
	{
		$this->view->load('default', 'purchase/purchase_history', ['title' => 'Manage Purchase']);
	}
	public function remaining_product()
	{
		$this->loadModel('product');

		$sales = $this->model->getSalesProduct();

		$this->view->load('default', 'product/remaining_product', [
			'title' => 'Product',
			'sales' => $sales,

		]);
	}
	public function postDamageProduct()
	{
		$this->view->load('default', 'product/add_damage', ['title' => 'Damage Product']);
	}
	public function loadBarcode()
	{
		$this->loadModel('product');

		$data = array();

		if (Input::exist()) {
			if (Input::get('true')) {
				$barcodes = $this->model->getBarcodeList();

				if (!is_null($barcodes) and !empty($barcodes)) {
					foreach ($barcodes as $barcode) {
						$data['barcode'][] = [$barcode->barcode_id, $barcode->barcode];
					}

				}
			}
		}


		echo json_encode($data);
	}
	public function loadBarcodes()
	{
		$this->loadModel('product');

		$data = array();


		if (Input::exist()) {
			if (Input::get('key')) {

				if (Input::get('pName') === 'get') {
					$stds = $this->model->getBarcodeList(true);

					if (!is_null($stds) and !empty($stds)) {
						foreach ($stds as $std) {
							$data['list'][] = $std->barcode . ' - ' . ucwords($std->product_name . ' ' . $std->product_subname);
						}
					}
				} else {
					$stds = $this->model->getBarcodeList(false);
					if (!is_null($stds) and !empty($stds)) {
						foreach ($stds as $std) {
							$data['list'][] = $std->barcode;
						}
					}
				}
			}
		}
		echo json_encode($data);
	}
	public function loadProductInfo()
	{
		$items = array();
		if (Input::exist()) {
			if (!is_null(Input::get('barcode'))) {
				$this->loadModel('product');

				$prodExist = $this->model->loadProductExist(Input::get('barcode'));

				if (!empty($prodExist)) {
					$items['product'] = $prodExist[0];
					$items['key'] = true;
				} else {
					$items['opt'] = $this->model->loadProductType();
				}
				// else{
				// 	$items['opt'] = $this->model->loadProductType();
				// }
			}
		}
		echo json_encode($items);
	}
}

