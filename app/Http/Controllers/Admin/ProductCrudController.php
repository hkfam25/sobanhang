<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'Danh sách sản phẩm');

        if(!backpack_user()->can('Quản lý hàng hóa')){
	    // deny access to operations
            CRUD::denyAccess(['list','show','create','update','delete']);
        }

    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */

        $this->crud->setColumns([
        ['name'=> 'name', // The db column name
            'label' => 'Tên hàng', // Column heading
            'type' => 'text', // The field type
        ],
        [
            'name' => 'sku',
            'label' => 'Mã hàng',
            'type' => 'text',
        ],
        [
            'name' => 'barcode',
            'label' => 'Mã vạch',
            'type' => 'text',
        ],
        [
            'label' => 'Loại hàng', // Column heading
            'type' => 'select',
            'name' => 'category_id', // the column that contains the ID of the related entity
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => \App\Models\Category::class, // optional
        ],
        'purchase_price',
        'selling_price',
        'quantity',
        'description',




    ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field([
        'type'      => 'select',
        'name'      => 'category_id',
        'model'     => \App\Models\Category::class,
        'attribute' => 'name',
        ])->validationRules('nullable|exists:categories,id');

        CRUD::field([
            'label' => 'Tên sản phẩm',
            'type'      => 'text',
            'name'      => 'name',
            'attribute' => 'name',
        ])->validationRules('required|min:1');

        CRUD::field([
            'type'      => 'text',
            'name'      => 'sku',
            'attribute' => 'name',
        ])->validationRules('unique:products,sku|nullable');

        CRUD::field([
            'type'      => 'text',
            'name'      => 'barcode',
            'attribute' => 'name',
        ])->validationRules('unique:products,barcode|nullable');
        


        CRUD::field([
        'label' => 'Phân loại hàng',
        'type'      => 'select',
        'name'      => 'category_id',
        'model'     => \App\Models\Category::class,
        'attribute' => 'name',
        ])->validationRules('required|exists:categories,id');




        CRUD::field([
        'label' => 'đơn vị tính',
        'type'      => 'text',
        'name'      => 'unit',
        // 'model'     => \App\Models\Products::class,
        'attribute' => 'name',
        ])->validationRules('nullable');

        CRUD::field('selling_price')->validationRules('required|min:2');

        // Stock Quantity (Số lượng tồn kho)
        CRUD::field([
        'label' => 'Hàng tồn kho',
        'type'      => 'number',
        'name'      => 'stock_quantity',
        'model'     => \App\Models\Products::class,
        'attribute' => 'name',
        ])->validationRules('required|min:1');
                
        CRUD::field([
        'label' => 'Giá bán',
        'type'      => 'number',
        'name'      => 'selling_price',
        'attribute' => 'name',
        ])->validationRules('required|min:2');

        CRUD::field([
        'label' => 'Giá mua',
        'type'      => 'number',
        'name'      => 'purchase_price',
        'attribute' => 'name',
        'default'=>0,
        ]);

        CRUD::field([
        'label' => 'Mức tồn kho tối thiểu',
        'type'      => 'number',
        'name'      => 'min_stock_level',
        'default'=>0,
        'attribute' => 'name',
        ])->validationRules('nullable');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
